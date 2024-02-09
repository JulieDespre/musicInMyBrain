import {WebSocketServer, WebSocket} from 'ws';

const server = new WebSocketServer({port: 3000, clientTracking: true});

const sendNotificationToAll = (msg) => {
    server.clients.forEach((client_socket) => {
        if (client_socket.readyState === WebSocket.OPEN) {
            client_socket.send(msg);
            console.log("Notification envoyer à tous les joueurs")
        }
    });
};

server.on('connection', function connection(client_socket) {
    console.log('Client connected');

    client_socket.on('message', function incoming(message) {
        console.log('Received: %s', message);
        sendNotificationToAll(message);
    });

    client_socket.on('close', function close() {
        console.log('Client disconnected');
    });
});

