const express = require("express");
const http = require("http");
const { Server } = require("socket.io");
const bodyParser = require("body-parser");
const cors = require("cors");

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: "*", // Ganti dengan alamat Vue.js-mu jika perlu
    methods: ["GET", "POST"],
  },
});

app.use(cors());
app.use(bodyParser.json());

// Endpoint dari Laravel
app.post("/notify", (req, res) => {
  const { message } = req.body;
  io.emit("notif", { message }); // broadcast ke semua socket client
  res.send({ status: "sent" });
});

// Socket connection
io.on("connection", (socket) => {
  console.log("Client connected:", socket.id);
});

server.listen(3001, () => {
  console.log("Socket.io Server running on http://localhost:3001");
});
