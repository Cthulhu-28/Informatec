var svg = undefined;
var g = undefined;
var width = 0;
var height = 0;
var r = 15;
var center = undefined;

function initEditor(x, y) {
    svg = d3.select('svg');
    g = svg.select('g');
    var viewBox = svg.attr('viewBox').split(' ');
    width = parseFloat(viewBox[2]);
    height = parseFloat(viewBox[3]);
    center = { x: (width - r) / 2, y: (height - r) / 2 };
    var zoom = d3.zoom()
        .extent([
            [0, 0],
            [width, height]
        ])
        .scaleExtent([1, 8])
        .on("zoom", zoomEvent);
    var k = 4;
    x = -k * x + center.x;
    y = -k * y + center.y;
    // d3.behavior.zoom().translate([x, y]).scale(k);
    g.attr("transform", `translate(${x},${y}) scale(${k})`);
    svg.call(zoom);
}

function newMarker() {
    svg.append("circle")
        .attr("transform", "translate(" + center.x + "," + center.y + ")")
        .attr("r", "15")
        .attr("class", "dot")
        .style("cursor", "pointer");
}

function zoomEvent() {
    var x = (center.x - d3.event.transform.x) / d3.event.transform.k;
    var y = (center.y - d3.event.transform.y) / d3.event.transform.k;
    $('#x_value').val(x);
    $('#y_value').val(y);
    g.attr("transform", d3.event.transform);
    console.log(d3.event.transform.toString());
}