var canvas;
var context;
var drawing = false;
var paths = new Array();
var lineWidth = 10;
var img;
var curColor = "#000000"
var id;


function Point(x, y, size, color){
	this.x = x
	this.y = y
	this.size = size;
	this.color = color;
}

function yscale(width, img){
	var ratio = width/img.width;
	return ratio * img.height;
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
	drawOneCircle($('.small:last')[0], 3);
	drawOneCircle($('.medium:last')[0], 10);
	drawOneCircle($('.large:last')[0], 20);
	drawOneCircle($('.extralarge:last')[0], 50);

}

function resetDimensions(){
	var rect = canvas.getBoundingClientRect();
	canvas.width = rect.right-rect.left;
	canvas.height = rect.bottom-rect.top;
}

function prepareCanvas(url, photo_id){
	
	paths = new Array();
	drawing = false;
	curColor = "#000000"
	lineWidth = 10;
	
	id = photo_id;
	canvas = $('.drawingCanvas:last')[0]
	if(typeof canvas === 'undefined') return;
	drawControls();	
	
	context = canvas.getContext("2d");
	img = new Image();
	img.src = url;
	img.onload = function(){
		canvas.style = "border:1px solid black;"
    	canvas.style.width = "100%";
		resetDimensions();
		canvas.height = yscale(canvas.width, img)
		
		
		canvas.style.backgroundImage = "url("+url+")";
		canvas.style.backgroundSize = "100% Auto";
	  	
		
		$('.drawingCanvas:last').mousedown(onMouseDown);
		$('.drawingCanvas:last').mousemove(onMouseMove);
		$('.drawingCanvas:last').mouseup(onMouseUp);
		$('.drawingCanvas:last').mouseleave(onMouseLeave);

		$('.drawingCanvas:last').touchstart(onMouseDown, false);
		$('.drawingCanvas:last').touchmove(onTouchMove, false);
		$('.drawingCanvas:last').touchend(onMouseUp, false);


		
	}


}

function onTouchMove(e){	
	e.preventDefault();
	if(drawing){

		var rect = canvas.getBoundingClientRect();

		var touches = event.touches;
		var x = touches[0].clientX;
		var y = touches[0].clientY
		var newPoint = new Point(x-rect.left, y-rect.top, lineWidth, curColor);
		paths[paths.length-1].push(newPoint);
	}
	redraw();
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



function onMouseMove(e){	


	if(drawing){
		var rect = canvas.getBoundingClientRect();
		var newPoint = new Point(e.clientX-rect.left, e.clientY-rect.top, lineWidth, curColor);
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
			context.strokeStyle = paths[i][j].color;
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

function getSizeString(size){
	var curId = "extralarge";
	if(size ==3){
		curId = "small";
	}else if(size ==10){
		curId = "medium";
	}else if (size == 20){
		curId = "large";
	}else if (size == 50){
		curId = "extralarge";
	}
	return curId;
}

function changeSize(size){
	var curId = getSizeString(lineWidth);
	$('.'+curId+':last')[0].style.backgroundColor = "#E0E0E0";
	
	$('.'+getSizeString(size)+':last')[0].style.backgroundColor = "#B0B0B0";

	lineWidth = size;
}

function changeColor(){
	
	curColor = $('.colorPicker:last')[0].value;
}

function save(){
	var val = $('.commentBox:last')[0].value;
	var dataURL = canvas.toDataURL();
	var request = new XMLHttpRequest();
	request.open('POST', 'save_image.php', false);
	request.setRequestHeader("Content-type", "application/upload")
	request.send(val+"&"+id+"&"+dataURL); // because of "false" above, will block until the request is done
	                // and status is available. Not recommended, however it works for simple cases.
	if (request.status === 200) {
		
	  alert("Posted!")
	}
}