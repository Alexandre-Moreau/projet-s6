const express = require("express")
const cors = require("cors")

const formatData = require("./data")

var app = express()

app.use(cors())

app.get("/data", (req, res) => {
  formatData().then(data => res.send(data))
    .catch(err => {
      throw err
      res.status(400).send(err)
    })
})

app.listen(30002)
