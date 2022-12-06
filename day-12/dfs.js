let N = 1000;
let adj =[];

// Function to print the complete DFS-traversal
function dfsUtil(u,node,visited,road_used,parent,it)
{
	let c = 0;

	// Check if all th node is visited or not
	// and count unvisited nodes
	for (let i = 0; i < node; i++)
		if (visited[i])
			c++;

	// If all the node is visited return;
	if (c == node)
		return;

	// Mark not visited node as visited
	visited[u] = true;

	// Track the current edge
	road_used.push([ parent, u ]);

	// Print the node
	console.log(u + " -> ");

	// Check for not visited node and proceed with it.
	for (let x=0;x<adj[u].length;x++)
	{
		// call the DFs function if not visited
		if (!visited[adj[u][x]])
		{
			dfsUtil(adj[u][x], node, visited, road_used, u, it + 1);
		}
	}

	// Backtrack through the last
	// visited nodes
	for(let y = 0; y < road_used.length; y++)
	{
		if(road_used[y][1] == u)
		{
			dfsUtil(road_used[y][0], node,
				visited,road_used, u, it + 1);
		}
	}
}

// Function to call the DFS function
// which prints the DFS-traversal stepwise
function dfs(node)
{
	// Create a array of visited node
	let visited = new Array(node);

	// Vector to track last visited road
	let road_used = [];

	// Initialize all the node with false
	for (let i = 0; i < node; i++)
	{
		visited[i] = false;
	}

	// call the function
	dfsUtil(0, node, visited, road_used, -1, 0);
}

// Function to insert edges in Graph
function insertEdge(u,v)
{
	adj[u].push(v);
	adj[v].push(u);
}

// Driver Code
let node = 6, edge = 7;
for(let i = 0; i < N; i++)
{
	adj.push([]);
}

insertEdge('0', '1');
insertEdge('0', '2');
insertEdge('1', '3');
insertEdge('1', '2');
insertEdge('2', '4');
insertEdge('1', '5');
insertEdge('2', '5');

// Call the function to print
dfs(node);
