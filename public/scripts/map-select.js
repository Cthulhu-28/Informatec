var svg = undefined;

function initEditor() {
    svg = d3.select('svg');
}

function newMarker() {

    // Extract the click location\    

    var p = { x: 10, y: 10 };

    // Append a new point
    svg.append("circle")
        .attr("transform", "translate(" + p.x + "," + p.y + ")")
        .attr("r", "15")
        .attr("class", "dot")
        .style("cursor", "pointer")
        .call(drag);
}


// Define drag beavior
var drag = d3.drag().on("drag", dragmove);

function dragmove(d) {
    var x = d3.event.x;
    var y = d3.event.y;
    d3.select(this).attr("transform", "translate(" + x + "," + y + ")");
    $('#x_value').val(x);
    $('#y_value').val(y);
    console.log(`x: ${x}, y: ${y}`);
}