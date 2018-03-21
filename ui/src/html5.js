// Canvas
window.onload = () => {
    var canvasE = document.getElementsByTagName("canvas").item(0);
    var context = canvasE.getContext("2d", {
        'alpha': true
    });
    // fillRect and strokeRect
    context.strokeStyle = "blue";
    context.fillStyle = "rgb(255,127,137)";
    context.fillRect(10, 10, 30, 30); // creates a black colored rectangle at 10 - x, 10 - y and with 10 width and 10 height.
    context.fillStyle = "rgba(255,0,0, 0.6)"; // this will not be used for creating above rectangle because the rectangle is already created and styles should be set before creating any shape.
    context.fillRect(20, 20, 30, 30);
    context.fillStyle = "rgb(222, 212, 0)"; // this will not work with strokeRect
    context.strokeRect(30, 30, 30, 30);

    // context.fillStyle = 'linear-gradient("red 70%, blue 40%, gree, 20%")';
    context.fillRect(40, 40, 40, 40);

    // fillText and strokeText
    // Beware that the alignment is based on the x value of the fillText() method. So if textAlign is "center", then the text would be drawn at x - (width / 2).
    context.beginPath(); context.moveTo(0, 5 + 0.5); context.lineTo(550, 5 + 0.5); context.stroke(); // baseline property for text is related to the line that we create over the text
    context.font = "14px Helvetica";
    context.textAlign = "start";
    context.textBaseline = "top";
    context.direction = "rtl";
    context.fillText("Kushagra", 100, 10, 200);
    console.log(context.measureText("Kushagra"));


    var baselines = ['top', 'hanging', 'middle', 'alphabetic', 'ideographic', 'bottom'];
    context.font = '36px serif';
    context.strokeStyle = 'red';

    baselines.forEach(function (baseline, index) {
        context.textBaseline = baseline;
        var y = 75 + index * 75;
        context.beginPath(); context.moveTo(0, y + 0.5); context.lineTo(550, y + 0.5); context.stroke();
        context.fillText('Abcdefghijklmnop (' + baseline + ')', 0, y);
    });

    // This creates a gradient at position x- 0, y - 500 and ends at x - 0, y - 700. This will correspond to the position and height and width of the rectangle.
    var gradient = context.createLinearGradient(0, 500, 0, 700);
    gradient.addColorStop(0, "green");
    gradient.addColorStop(1, "white");
    gradient.addColorStop(0.54, "yellow");
    context.fillStyle = gradient;
    context.fillRect(10, 500, 200, 100);

    // createLinearGradient method is used to create a CanvasGradient with the specified start and end points. Once created, you can use the CanvasGradient.addColorStop() method to define new stops on the gradient with specified offsets and colors. The gradient gets applied if you set it as the current fillStyle and gets drawn onto the canvas when using the fillRect() method, for example.

    // Creating radial gradient will be same just two more coordinates come in that are start radius and end radius. The calculation is done from the circle end to the center. This means that we move from starting circle to ending circle.

    // createRadialGradient will start at the circumference of the circle and end at the center and the start and end are relative to each other.

    var ctx = context;

    var gradient = ctx.createRadialGradient(350, 600, 10, 350, 600, 0);
    gradient.addColorStop(0, 'white');
    gradient.addColorStop(1, 'green');
    ctx.fillStyle = gradient;
    ctx.fillRect(250, 500, 200, 200);


    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');

    var img = new Image();
    img.src = 'https://mdn.mozillademos.org/files/222/Canvas_createpattern.png';
    img.onload = function () {
        var pattern = ctx.createPattern(img, 'repeat');
        ctx.fillStyle = pattern;
        ctx.fillRect(0, 0, 400, 400);
    };

    // Path
    // Paths contains two steps creation and drawing. Unlike fillRect or strokeRect there are no direct methods to create and draw in one go.
    // We need two sets of methods first for creating paths and then the others for drawing them on to canvas.

    // Using create path apis we can create multiple shapes such as line , rectangle, arc, ellipse. All of these will not be drawn by .fill because fill only works for the shapes which can be filled but line is a thin single line which cannot be filled but can only be stroked.
    var canvass = document.getElementById('path');
    var ctxs = canvass.getContext('2d');
    ctxs.beginPath();
    ctxs.moveTo(10, 10); // moveTo locates the actual points on the canvas. Wihtout this the starting points will be 0, 0
    ctxs.strokeStyle = "green"
    ctxs.lineTo(100, 100);
    // just by doing this will not create any path, we need to stroke it or fill it
    ctxs.stroke();
    ctxs.strokeStyle = "yellow"
    ctxs.lineTo(110, 220); // this will be started from where the last path left or ended.
    // just by doing this will not create any path, we need to stroke it or fill it
    ctxs.stroke(); // this will stroke all the sub paths not only the path on which it is used.

    ctxs.closePath(); // close path will not destroy the paths but will actually try to close the paths by joining the ends .  It tries to draw a straight line from the current point to the start. If the shape has already been closed or has only one point, this function does nothing

    ctxs.lineTo(150, 250); // this will be started from where the last path left or ended.
    // // just by doing this will not create any path, we need to stroke it or fill it
    ctxs.stroke(); // this will stroke all the sub paths not only the path on which it is used.

    ctxs.closePath();
    // ctxs.fillStyle = "blue"
    ctxs.stroke();
    // ctxs.fill();
    // fill and fillStyle work above because the shape created by paths is completely closed.

    // Bezier Curve
    // If we dont't give 
    var canvasB = document.getElementById('path');
    var ctxB = canvasB.getContext('2d');
    ctxB.beginPath(); // this is not mandatory when starting a new path. It just revokes all the references to previous paths and start points and end points. If not using this and moveTo the paths will start at 0,0.
    ctxB.moveTo(200, 30);
    ctxB.lineTo(220, 200);
    ctxB.beginPath(); // resets the points.
    ctxB.bezierCurveTo(220, 60, 100, 190, 260, 140); // two control points are just to pull the curve. If there in no moveTo the first control point become the starting point.
    ctxB.stroke();
    // all sub paths start from where the previous path has ended.

    // Quadratic curve needs only two points. One control point, the other end point.
    // Three points are required to pull a line and make it a curve. Hence in quadratic curve if we donot give moveTo, there are only two points and hence we always get a straight line.
    ctxB.beginPath();
    ctxB.moveTo(200, 30);
    ctxB.quadraticCurveTo(240, 70, 130, 150); // picks up the ending point of above curve to be its starting point.s
    ctxB.stroke();

    // Arc
    // Arc start and end angle is in radians and not in degrees. So the circle starts getting drawn at the given start angle and stop at the given end angle. Till the time the end angle is lesser than the start angle it is calculated in reference to the +ve x-axis and and once the 360 deg or 6 radians are over (if starting radian is 0) then all the other radians are calculated in reference to the start radian. So for example if start angle is 5 and end angle is 3 then 3 is calculated from x-axis but if end angle is 6, it will be calculated according to the start angle that is 5 hence the cricle will stop 1 radian after 5.

    // ctxB.beginPath(); // If we dont use this a line will automatically be drawn to connect the last end point of the last path and the arc start point.
    ctxB.fillRect(240, 120, 5, 5);
    ctxB.beginPath();
    ctxB.arc(240, 120, 30, 5, 4); // the angle is also counted as clockwise keeping diameter of the circle as x and y axis.
    ctxB.stroke();

    var canvas = document.getElementById('arcs');
    var ctxA = canvas.getContext('2d');
    for (var i = 0; i < 4; i++) {
        for (var j = 0; j < 3; j++) {
            ctxA.beginPath();
            var x = 25 + j * 50;               // x coordinate
            var y = 25 + i * 50;               // y coordinate
            var radius = 20;                    // Arc radius
            var startAngle = 0;                     // Starting point on circle
            var endAngle = Math.PI + (Math.PI * j) / 2; // End point on circle
            var anticlockwise = i % 2 == 1;                // Draw anticlockwise

            console.log(startAngle, endAngle);
            ctxA.arc(x, y, radius, startAngle, endAngle, anticlockwise);

            if (i > 1) {
                ctxA.fill();
            } else {
                ctxA.stroke();
            }
        }
    }

    // Arc to.
    // arcTo can be used to create a line using the given control points and an arc at the end of the control points using the radius given.
    ctxB.beginPath();
    ctxB.moveTo(50, 320); // start from here then goes to first control point in red and the from there to second control point in red. If we remove this moveTo it start from first control point.
    ctxB.arcTo(150, 100, 50, 20, 30);
    ctxB.lineTo(50, 20)
    ctxB.strokeStyle = "green"
    ctxB.stroke();

    ctxB.fillStyle = 'blue';
    // starting point
    ctxB.fillRect(50, 320, 10, 10);

    ctxB.fillStyle = 'red';
    // control point one
    ctxB.fillRect(150, 100, 10, 10);
    // control point two
    ctxB.fillStyle = 'yellow';
    ctxB.fillRect(50, 20, 10, 10);

    // Ellipse
    ctxB.beginPath();
    ctxB.ellipse(230, 300, 20, 50, 5, 5, 4.99);
    ctxB.stroke();

    // Rect
    ctxB.beginPath();
    ctxB.rect(100, 330, 100, 100);
    ctxB.fill();

    // drawFocusIfNeeded
    // drawFocusIfNeeded() method of the Canvas 2D API draws a focus ring around the current path or given path, If a given element is focused.
    var canvasD = document.getElementById("drawIfNeeded");
    var ctxD = canvasD.getContext("2d");
    var button = document.getElementById('button');

    button.focus();

    ctxD.beginPath();
    // ctxD.fillStyle = "blue"
    // ctxD.strokeStyle = "2px solid"
    ctxD.rect(10, 10, 30, 30);
    ctxD.drawFocusIfNeeded(button);

    // ctxD.beginPath();
    // ctxD.fillRect(50, 10, 30, 30);
    // ctxD.scrollPathIntoView();

    // Clip
    // Create clipping region
    // clips the last path and merges it with the first one. If possible.
    var canvasC = document.getElementById('clip');
    var ctxC = canvasC.getContext('2d');
    // LineWidth 
    // not only affects the line width but also affects stroke width.
    ctxC.beginPath();
    ctxC.moveTo(20, 220);
    // ctxC.fillRect(10, 200, 10,10);
    ctxC.lineWidth = 20
    ctxC.lineTo(20, 370);
    ctxC.stroke();

    ctxC.save();
    ctxC.beginPath();
    ctxC.arc(100, 100, 75, 0, Math.PI * 2, false);
    // ctxC.ellipse(100, 100, 75, 45, 2, 0, Math.PI * 2);
    ctxC.clip(); // clips everything that follows clip() into the path before clip() // unless ctx.save() and ctx.restore() are called.

    ctxC.fillRect(0, 0, 100, 100);
    // ctxD.fillRect(0, 0, 100,100);

    // isPointInPath and isPointInStroke

    ctxC.restore();
    ctxC.beginPath();
    ctxC.moveTo(120, 120);
    // ctxC.fillRect(10, 200, 10,10);
    ctxC.lineWidth = 20// not only affects the line width but also affects stroke width.
    ctxC.lineCap = "round" // tells how line ending show. Values are round, butt- default, square
    ctxC.lineTo(220, 280);
    ctxC.stroke();

    var lineJoin = ['round', 'bevel', 'miter'];
    ctxC.lineWidth = 10;
    ctxC.strokeStyle = "blue"
    for (var i = 0; i < lineJoin.length; i++) {
        ctxC.lineJoin = lineJoin[i]; // decides by what shape two paths will be joined. 
        ctxC.beginPath();
        if (lineJoin[i] == "miter") {
            ctxC.miterLimit = 100;
        }
        ctxC.moveTo(-5, 5 + i * 40);
        ctxC.lineTo(35, 45 + i * 40);
        ctxC.lineTo(75, 5 + i * 40);
        ctxC.lineTo(115, 45 + i * 40);
        ctxC.lineTo(155, 5 + i * 40);
        ctxC.stroke();
    }


    // Miter Limit
    // set the max length of miter
    var canvasML = document.getElementById("miterLimit");
    var ctxML = canvasML.getContext('2d');
    ctxML.lineWidth = 10;
    ctxML.lineJoin = "miter";
    ctxML.miterLimit = 7;
    ctxML.moveTo(20, 20);
    // ctxML.rotate(7);    
    ctxML.lineTo(50, 100);
    ctxML.lineTo(70, 20);
    ctxML.lineTo(90, 120);
    ctxML.lineTo(110, 20);
    ctxML.lineTo(130, 140);
    ctxML.lineTo(150, 20);
    ctxML.lineTo(170, 160);
    ctxML.lineTo(190, 20);
    ctxML.lineTo(210, 180);
    ctxML.lineTo(230, 20);
    ctxML.lineTo(250, 200);
    ctxML.stroke();

    // setLineDash
    // takes segments -> array of integers which describe the length of dash and space alternatively
    ctxML.save();
    ctxML.beginPath();
    ctxML.moveTo(80, 280);
    ctxML.lineWidth = 1;
    ctxML.setLineDash([10, 12, 2]); // it says 10 as first dash length, 12 as space length, 2 as another dash length. No affect with beginPath().
    ctxML.lineTo(280, 280);
    ctxML.stroke();
    // getLineDash
    console.log(ctxML.getLineDash())
    ctxML.restore();
    // lineDashOffset
    ctxML.beginPath();
    var offset = 0;

    //The CanvasRenderingContext2D.clearRect() method of the Canvas 2D API sets all pixels in the rectangle defined by starting point (x, y) and size (width, height) to transparent black, erasing any previously drawn content.
    // So ctx.clearRect(10, 10, 100, 100); will clear the rectalgular portion from 10, 10 and having height and width of 100, 100.

    function moveAnts() {
        ctxML.clearRect(10, 200, 300, 400); // destroy old and create new
        ctxML.lineWidth = 5;
        ctxML.setLineDash([5, 10]);
        ctxML.lineDashOffset = -offset;
        ctxML.strokeRect(20, 300, 200, 200);
    }
    function movingAnts() {
        offset++;
        if (offset > 16) {
            offset = 0;
        }
        moveAnts();
        setTimeout(movingAnts, 20);
    }
    // movingAnts();

    // ctxML.lineDashOffset = 20

    var shadowCanvas = document.getElementById("shadow");
    var ctxSh = shadowCanvas.getContext('2d');
    // The rotation center point is always the canvas origin.
    ctxSh.globalAlpha = 0.7 // specifies global alpha value for all the shapes
    ctxSh.rotate(6.9);
    ctxSh.shadowColor = 'red';
    ctxSh.shadowBlur = 30;
    ctxSh.shadowOffsetX = 10;
    ctxSh.shadowOffsetY = 10;

    ctxSh.fillStyle = 'white';
    ctxSh.fillRect(10, 10, 100, 100);

    var transformCanvas = document.getElementById("transform");
    var ctxT = transformCanvas.getContext('2d');
    // Browsers have not implemented it yet
    var matrix = ctxT.currentTransform; // not implemented
    matrix.a = 2;
    matrix.b = 1;
    matrix.c = 0;
    matrix.d = 1;
    matrix.e = 0;
    matrix.f = 0;
    ctxT.currentTransform = matrix;
    ctxT.fillRect(0, 0, 100, 100);

    ctxT.save();
    ctxT.rotate(6);
    ctxT.scale(1.4, 1.3);
    ctxT.translate(2, 25); // moves the shape x horizontally and y vertically
    // transform and setTransform. transform multiplies currentTransform matrix values to corresponding martix values given in transform method.
    // setTransform resets the currentTransform matrix to unity and then performs transforms on given matrix values.
    /**
     * m11 -> hori scale
     * m12 -> hori skew
     * m21 -> ver skew
     * m22 ver scale
     * x -> translate hori by x
     * y -> translate ver by y
     */
    ctxT.globalAlpha = 0.7
    ctxT.transform(2, 0, 1, 1, 1, 1);
    ctxT.transform(1.8, 1, 2, 1, 1, 1); // multiplies with above previous transform
    ctxT.fillRect(10, 10, 100, 50);
    ctxT.restore();
    ctxT.beginPath();
    ctxT.moveTo(0, 0);
    ctxT.transform(2, 0, 1, 1, 1, 1);
    ctxT.setTransform(3, 1, 1, 1, 1, 1); // resets above transform and then applies transform on these values
    ctxT.rect(10, 10, 100, 100);
    ctxT.stroke();
    // Types of styles
    // fillStyle, strokeStyle,
    // text styles font, textAlign, textBaseLine, direction
    // Line Styles control how lines are drawn

    // Image
    var canvasI = document.getElementById('destination');
    var ctxI = canvasI.getContext('2d');
    var image = document.getElementById('source');


    ctxI.drawImage(image, 33, 71, 400, 104, 50, 20, 100, 104); // it will be observed that when we increase the width of the destination canvas it starts squeezing the image thats because it increases the width inside the visible image area but not actually the visiable area and hence when the area inside the visible area is increased it tries to show more of the image inside that and hence scales the image. If we need to increase the visible size then we need to increase the size of source width. 
    /**
     * image: can be anything from which we can pick the pixels. It can also be video.
     * dx
        The X coordinate in the destination canvas at which to place the top-left corner of the source image.
       dy
        The Y coordinate in the destination canvas at which to place the top-left corner of the source image.
       dWidth
        The width to draw the image in the destination canvas. This allows scaling of the drawn image. If not specified, the image is not scaled in width when drawn.
       dHeight
        The height to draw the image in the destination canvas. This allows scaling of the drawn image. If not specified, the image is not scaled in height when drawn.
       sx
        The X coordinate of the top left corner of the sub-rectangle of the source image to draw into the destination context.
       sy
        The Y coordinate of the top left corner of the sub-rectangle of the source image to draw into the destination context.
       sWidth
        The width of the sub-rectangle of the source image to draw into the destination context. If not specified, the entire rectangle from the coordinates specified by sx and sy to the bottom-right corner of the image is used.
       sHeight
        The height of the sub-rectangle of the source image to draw into the destination context.
     */
    var img = new Image();
    img.src = 'https://mdn.mozillademos.org/files/222/Canvas_createpattern.png';
    img.onload = function () {
        ctxI.imageSmoothingQuality = "medium";
        ctxI.mozImageSmoothingEnabled = false;
        ctxI.webkitImageSmoothingEnabled = true;
        ctxI.msImageSmoothingEnabled = false;
        ctxI.imageSmoothingEnabled = true; // smoothens the edges in the image drawn
        ctxI.drawImage(img, 0, 150, 400, 200);
    };
    console.log(ctxI.canvas); // returns the corresponding canvas element

    // Add hit region
    // Labels or marks a region inside the canvas element so that path or shape we can bind events on that
    canvasI.addEventListener('mousemove', function (event) {
        if (event.region == "eyes") {
            alert('ouch, my eye :(');
            console.log(event.region);
        } else if (event.region == "mouth") {
            alert("ouch, my mouth :(");
            console.log(event.region);
            ctxI.removeHitRegion('mouth');
        }
    });
    ctxI.beginPath();
    ctxI.arc(100, 450, 75, 0, 2 * Math.PI, false);
    ctxI.lineWidth = 5;
    ctxI.stroke();

    // eyes
    ctxI.beginPath();
    ctxI.arc(70, 430, 10, 0, 2 * Math.PI, false);
    ctxI.arc(130, 430, 10, 0, 2 * Math.PI, false);
    ctxI.fill();
    ctxI.addHitRegion({ id: "eyes" }); // id is the value of event.region.

    // mouth
    ctxI.beginPath();
    ctxI.arc(100, 450, 50, 0, Math.PI, false);
    ctxI.stroke();
    ctxI.addHitRegion({ id: "mouth", label: "control" });

    //clearHitRegions

    // basic animations
    var canvasA = document.getElementById('animation1');
    var sun = new Image();
    var moon = new Image();
    var earth = new Image();
    function init() {
        sun.src = 'https://mdn.mozillademos.org/files/1456/Canvas_sun.png';
        moon.src = 'https://mdn.mozillademos.org/files/1443/Canvas_moon.png';
        earth.src = 'https://mdn.mozillademos.org/files/1429/Canvas_earth.png';
        window.requestAnimationFrame(draw);
    }

    function draw() {
        var ctxAn = canvasA.getContext('2d');

        ctxAn.globalCompositeOperation = 'destination-over';
        ctxAn.clearRect(0, 0, 300, 300); // clear canvas

        ctxAn.fillStyle = 'rgba(0, 0, 0, 0.4)';
        ctxAn.strokeStyle = 'rgba(0, 153, 255, 0.4)';
        ctxAn.save();
        ctxAn.translate(150, 150);

        // Earth
        var time = new Date();
        ctxAn.rotate(((2 * Math.PI) / 60) * time.getSeconds() + ((2 * Math.PI) / 60000) * time.getMilliseconds());
        ctxAn.translate(105, 0);
        ctxAn.fillRect(0, -12, 50, 24); // Shadow
        ctxAn.drawImage(earth, -12, -12);

        // Moon
        ctxAn.save();
        ctxAn.rotate(((2 * Math.PI) / 6) * time.getSeconds() + ((2 * Math.PI) / 6000) * time.getMilliseconds());
        ctxAn.translate(0, 28.5);
        ctxAn.drawImage(moon, -3.5, -3.5);
        ctxAn.restore();

        ctxAn.restore();

        ctxAn.beginPath();
        ctxAn.arc(150, 150, 105, 0, Math.PI * 2, false); // Earth orbit
        ctxAn.stroke();

        ctxAn.drawImage(sun, 0, 0, 300, 300);

        window.setTimeout(draw, 10);
        //window.requestAnimationFrame(draw);
    }

    // init();
    var ctxAn = canvasA.getContext('2d');
    ctxAn.rect(10, 10, 100, 100);
    ctxAn.fill();
    var imgDC = ctxAn.createImageData(100, 100)
    console.log(imgDC); // intakes height and width of the new image data to create or takes another imagedata object to copy height and width but not the actual data.
    var imgDG = ctxAn.getImageData(20, 20, 50, 50);
    console.log(imgDG);

    var imagedata = ctxAn.getImageData(0, 0, 100, 100);
    ctxAn.putImageData(imagedata, 120, 0); // paints complete image data obtained from getImageData
    ctxAn.putImageData(imagedata, 180, 0, 50, 50, 25, 25); // if dirty rectangle is provided then it cuts out that portion only from the imagedata.

    var draggableElements = document.querySelectorAll("#draggable-content > #columns > .column");
    
    draggableElements.forEach((element) => {
        // Drag event
        // Keeps happening untill mouse is released.
        element.addEventListener("drag", () => {
            console.log("%c Drag Event ", "background: yellow; color: black; font-size: 16px; font-weight: bold");
            // if(element.style.opacity == 1 || element.style.opacity == null || element.style.opacity == "") {
            //     element.style.opacity = 0;
            // } else {
            //     console.log(element.style.opacity);
            // console.log(element.style.opacity);
            //     element.style.opacity = parseFloat(element.style.opacity)+0.1;
            // }
        });

        // Drag start event        
        element.addEventListener("dragstart", (e) => {
            element.classList.add("marching-ants");
            element.classList.add("marching");
            console.log("%c Drag Start Event ", "background: orange; color: white; font-size: 24px; font-weight: bold");
            e.dataTransfer.setData("Text", "Dummy Text");
            e.dataTransfer.effectAllowed = "copy";
            e.dataTransfer.dropEffect = "move"
            var dragImage = document.createElement("img");
            dragImage.src = "img/drag.jpg";
            dragImage.style.height = "20px"
            dragImage.style.width = "20px"            
            e.dataTransfer.setDragImage(dragImage, 500, 500)
        });
        // Drag End Event
        element.addEventListener("dragend", () => {
            element.classList.remove("dragOver");            
            element.style.opacity = 1;
            element.classList.remove("marching-ants");
            element.classList.remove("marching");
            console.log("%c Drag End Event ", "background: green; color: white; font-size: 22px; font-weight: bold");
        });

        // Drag Enter Event 
        element.addEventListener("dragenter", () => {
            element.classList.add("dragOver");
            console.log("%c Drag Enter Event ", "background: pink; color: white; font-size: 20px; font-weight: bold");
        });

        // Drag Leave Event 
        element.addEventListener("dragleave", () => {
            element.classList.remove("dragOver");
            console.log("%c Drag Leave Event ", "background: purple; color: white; font-size: 18px; font-weight: bold");
        });

        // Drag Exit Event 
        element.addEventListener("dragexit", () => {
            console.log("%c Drag Exit Event ", "background: skyblue; color: white; font-size: 16px; font-weight: bold");
        });

        // Drag Over Event 
        // By default, data/elements cannot be dropped in other elements. To allow a drop, we must prevent the default handling of the element and hence allowing drop event.
        element.addEventListener("dragover", (e) => {
            e.preventDefault();
            console.log("%c Drag Over Event ", "background: darkgreen; color: white; font-size: 14px; font-weight: bold");
        });

        // Drop Event 
        element.addEventListener("drop", function(e) {
            element.classList.remove("dragOver");                        
            e.preventDefault();
            console.log("%c Drop Event ", "background: black; color: white; font-size: 12px; font-weight: bold");
            if(e.dataTransfer.files && e.dataTransfer.files.length) {
                console.log(e.dataTransfer.files);
            } else {
                console.log(e.dataTransfer.getData("Text"));
            }
        });
    });

}

function checkCam() {
    if ('mediaDevices' in window.navigator && 'getUserMedia' in window.navigator.mediaDevices) {
        var webCamRenderHolder = document.getElementById('canvas-webcam');
        var docFrag = document.createDocumentFragment();
        var buttonsContainer = document.getElementById("buttons-container");
        var videoNode = document.createElement("video");
        var buttonCamStartNode = document.createElement("button");
        var buttonTakeSnapNode = document.createElement("button");
        var buttonPauseCamNode = document.createElement("button");
        var buttonPlayCamNode = document.createElement("button");
        var buttonStopCamNode = document.createElement("button");
        var canvasNode = document.createElement("canvas");
        var streamO = null;

        // Attach Buttons
        buttonCamStartNode.id = "start-cam";
        buttonCamStartNode.textContent = "Start Cam";
        buttonCamStartNode.onclick = () => {
            navigator.mediaDevices.getUserMedia({ video: true, /*audio: true*/ }).then((stream) => {
                videoNode.src = window.URL.createObjectURL(stream);
                // videoNode.play();
                streamO = stream;
            });
        }
        
        buttonTakeSnapNode.id = "snap-it";
        buttonTakeSnapNode.textContent = "Take a Snap";
        buttonTakeSnapNode.onclick = () => {
            var context = canvasNode.getContext('2d');
            context.drawImage(videoNode, 0,0);
        }

        buttonPauseCamNode.id = "pause-it";
        buttonPauseCamNode.textContent = "Pause Video";
        buttonPauseCamNode.onclick = () => {
            videoNode.pause();
        }

        buttonPlayCamNode.id = "play-it";
        buttonPlayCamNode.textContent = "Play Video";
        buttonPlayCamNode.onclick = () => {
            videoNode.play();
        }

        buttonStopCamNode.id = "stop-it";
        buttonStopCamNode.textContent = "Stop Video";
        buttonStopCamNode.onclick = () => {
            videoNode.src = "";
            for(stream of streamO.getTracks()) {
                stream.stop()
            }
        }

        buttonsContainer.appendChild(buttonCamStartNode);
        buttonsContainer.appendChild(buttonTakeSnapNode);
        buttonsContainer.appendChild(buttonPauseCamNode);
        buttonsContainer.appendChild(buttonPlayCamNode);
        buttonsContainer.appendChild(buttonStopCamNode);

        // Attach video element
        videoNode.id = "video";
        videoNode.height = 480;
        videoNode.width = 640;
        videoNode.controls = true;
        videoNode.autoplay = true;
        docFrag.appendChild(videoNode);

        // Attach canvas element
        canvasNode.id = "webcam-snap";
        canvasNode.height = 480;
        canvasNode.width = 640;
        docFrag.appendChild(canvasNode);

        webCamRenderHolder.appendChild(docFrag);

        document.getElementById("check-cam").style.display = "none";
    } else {
        alert("Webcam API not supported by your browser.");
    }
}
