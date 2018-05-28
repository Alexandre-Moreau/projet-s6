console.load('loaded');

width = 350;
height = 600;
var glob_node;
var glob_link;
var glob_label;
var glob_dataset;

	function createGraph(dataset, placement){

		glob_dataset = dataset;

		var svg = d3.select(placement)
			.append("svg")
			.attr("width", width)
			.attr("height", height);

		var simulation = d3.forceSimulation().nodes(dataset.nodes);

		simulation
			.force("charge_force", d3.forceManyBody().strength(-750))
			.force("center_force", d3.forceCenter(width / 2, height / 2));

		var link_force =  d3.forceLink(dataset.links)
			.id(function(d) { return d.id; });

		link_force.distance(20);

		simulation.force("links",link_force)

		glob_link = svg.append("g")
			.attr("class", "links")
			.selectAll("line")
			.data(dataset.links)
			.enter().append("line")
			.attr("stroke-width", 2);

		glob_node = svg.append("g")
			.attr("class", "nodes")
			.selectAll("circle")
			.data(dataset.nodes)
			.enter()
			.append("circle")
			.attr("r", 5)
			.attr("node_selected", "false")
			.attr("node_id", function (d) { return d.id; });

		glob_label = svg.selectAll(null)
			.data(dataset.nodes)
			.enter()
			.append("text")
			.text(function (d) { return d.name; })
			.style("text-anchor", "middle")
			.style("font-family", "Arial")
			.style("font-size", 12)
			.attr("node_id", function (d) { return d.id; });

		simulation.on("tick", tickActions);
	}

	function tickActions() {
		//update circle positions each tick of the simulation 
		glob_node
			.attr("cx", function(d) { return d.x; })
			.attr("cy", function(d) { return d.y; })
			.attr("fill", function(d) {if(d.node_selected!=null && d.node_selected==true) { return "#0739d0"; } else if(d.id=="0"){ return "#ffffff"; } else { return "#404040"; } }); 

		//update link positions 
		//simply tells one end of the line to follow one node around
		//and the other end of the line to follow the other node around
		glob_link
			.attr("x1", function(d) { return d.source.x; })
			.attr("y1", function(d) { return d.source.y; })
			.attr("x2", function(d) { return d.target.x; })
			.attr("y2", function(d) { return d.target.y; })
			.attr("stroke", function(d) {if(d.source.id=="0" || d.target.id=="0"){ return "#ffffff"; } else { return "#808080"; } });

		glob_label
			.attr("x", function(d) { return d.x; })
			.attr("y", function(d) { return d.y+20; })
			.attr("fill", function(d) {if(d.node_selected!=null && d.node_selected==true) { return "#0739d0"; } else if(d.id=="0"){ return "#ffffff"; } else { return "#404040"; } }); 
	}

	

	