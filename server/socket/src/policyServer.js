const net = require('net');

function PolicyServer(){
    var clients = [];
    var server = net.createServer(function(socket) {
        console.log('Connecting policy');
    });
    server.listen(843, process.env.IP||'0.0.0.0');
    console.log('Policy Server listening on port 843');
}
module.exports = PolicyServer();


/*var clients = [];
net.createServer(function(socket) {
    socket.name = socket.remoteAddress + ":" + socket.remotePort

    clients.push(socket);

    socket.write("Welcome " + socket.name + "\n");
    broadcast(socket.name + " joined the chat\n", socket);

    // Handle incoming messages from clients.
    socket.on('data', function(data) {
        broadcast(socket.name + "> " + data, socket);
    });

    // Remove the client from the list when it leaves
    socket.on('end', function() {
        clients.splice(clients.indexOf(socket), 1);
        broadcast(socket.name + " left the chat.\n");
    });

    // Send a message to all clients
    function broadcast(message, sender) {
        clients.forEach(function(client) {
            // Don't want to send it to sender
            if (client === sender) return;
            client.write(message);
        });
        // Log it to the server output too
        process.stdout.write(message)
    }

}).listen(843);


console.log("Chat server running at port 5000\n");
*/