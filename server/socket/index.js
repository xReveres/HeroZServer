// module dependencies
const policyServer = require('./src/policyServer.js');
const http = require("http"),
    sio  = require("socket.io"),
    IO_PORT= 8081, IO_IP=process.env.IP||'0.0.0.0';

const server = http.createServer().listen(IO_PORT, IO_IP),
io = sio.listen(server);

io.sockets.on('connection', function (socket) {
    console.log('Connected :D');
    socket.emit('clientRegistered', {name:'clientRegistered'});
    socket.on('event', function(data){
        console.log(data);
    });
});