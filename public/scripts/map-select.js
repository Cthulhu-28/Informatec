var svg = undefined;
var g = undefined;
var width = 0;
var height = 0;
var r = 15;
var center = undefined;

function initEditor() {
    svg = d3.select('svg');
    g = svg.select('g');
    var viewBox = svg.attr('viewBox').split(' ');
    width = parseFloat(viewBox[2]);
    height = parseFloat(viewBox[3]);
    svg.call(zoom);
}

function newMarker() {

    // Extract the click location\    

    center = { x: (width - r) / 2, y: (height - r) / 2 };

    // Append a new point
    svg.append("circle")
        .attr("transform", "translate(" + center.x + "," + center.y + ")")
        .attr("r", "15")
        .attr("class", "dot")
        .style("cursor", "pointer");
}


var zoom = d3.zoom()
    .extent([
        [0, 0],
        [962.9, 1041.8]
    ])
    .scaleExtent([1, 8])
    .on("zoom", zoomEvent);

// function dragmove(d) {
//     var x = d3.event.x;
//     var y = d3.event.y;
//     d3.select(this).attr("transform", "translate(" + x + "," + y + ")");
//     $('#x_value').val(x);
//     $('#y_value').val(y);
//     // console.log(`x: ${x}, y: ${y}`);
//     console.log('DRAG');
// }

function zoomEvent() {
    var x = (center.x - d3.event.transform.x) / d3.event.transform.k;
    var y = (center.y - d3.event.transform.y) / d3.event.transform.k;
    // console.log(d3.event.transform);
    // console.log(`x: ${x}, y: ${y}`);
    $('#x_value').val(x);
    $('#y_value').val(y);
    g.attr("transform", d3.event.transform);
}