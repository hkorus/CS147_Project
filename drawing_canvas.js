var canvas;
var context;
var drawing = false;
var paths = new Array();
var lineWidth = 3;
var img;


function Point(x, y, size){
	this.x = x
	this.y = y
	this.size = size;
}

function xscale(height, img){
	var ratio = height/img.height;
	return ratio * img.width;
}

function drawOneCircle(controlCanvas, size){
	ctx = controlCanvas.getContext("2d");
	ctx.beginPath();
	var locx = size/2+((controlCanvas.width-size)/2);
	var locy = size/2+((controlCanvas.height-size)/2);
	
	ctx.arc(locx, locy, size/2, 0, Math.PI*2, true); 
	ctx.closePath();
	ctx.fill();
	
}

function drawControls(){
	drawOneCircle(document.getElementById('small'), 3);
	drawOneCircle(document.getElementById('medium'), 10);
	drawOneCircle(document.getElementById('large'), 20);
	drawOneCircle(document.getElementById('extralarge'), 50);
	
}

function prepareCanvas(url){
	
	drawControls();
	
	canvas = document.getElementById('canvas');
	context = canvas.getContext("2d");
	img = new Image();
	img.src = url;
	
	canvas.height = 500;
	canvas.width = xscale(500, img);
	  
	$('#canvas').mousedown(onMouseDown);
	$('#canvas').mousemove(onMouseMove);
	$('#canvas').mouseup(onMouseUp);
	$('#canvas').mouseleave(onMouseLeave);
}

function onMouseDown(e){	
	drawing = true;
	paths.push(new Array());
	redraw();
}

function onMouseUp(e){
	drawing = false;
	redraw();
}

function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect(), root = document.documentElement;
        // return relative mouse position
        var mouseX = evt.clientX - rect.left - root.scrollLeft;
        var mouseY = evt.clientY - rect.top - root.scrollTop;
        return {
          x: mouseX,
          y: mouseY
        };
}

function onMouseMove(e){	
	
	if(drawing){
		var mouse = getMousePos(canvas, e);
		var newPoint = new Point(mouse.x, mouse.y, lineWidth);
		paths[paths.length-1].push(newPoint);
	}
	redraw();
}

function onMouseLeave(e){
	drawing = false;
}

function redraw(){
  
  canvas.width = canvas.width; // Clears the canvas
  context.lineJoin = "round";
   		
  for(var i=0; i < paths.length; i++)
  {	
	context.beginPath();
	for(var j = 0; j< paths[i].length ; j++){
		if(j==0){
			context.moveTo(paths[i][j].x, paths[i][j].y)
			context.lineWidth = paths[i][j].size;
		}
     	context.lineTo(paths[i][j].x, paths[i][j].y);
	}
	context.stroke();
  }
}

function undo(){
	paths.pop();
	redraw();
}

function changeSize(size){
	lineWidth = size;
}

function save(){
	var dataURL = canvas.toDataURL();
	var request = new XMLHttpRequest();
	request.open('POST', 'http://stanford.edu/~lcuth/cgi-bin/CS147_Project/save_image.php', false);
	request.setRequestHeader("Content-type", "application/upload")
	
	request.send(dataURL); // because of "false" above, will block until the request is done
	                // and status is available. Not recommended, however it works for simple cases.
	if (request.status === 200) {
	  alert("Saved!")
	}
}
