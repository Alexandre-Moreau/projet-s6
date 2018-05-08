const mysql = require("mysql")
const fs = require("fs")

const getDataPromise = (query) => new Promise((resolve, reject) => {
  var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'root',
    password : '',
    database : 'projet-s6'
  });

  connection.connect();

  connection.query(query, function (err, results, fields) {
    if(err){
      reject(err)
      return
    }
    resolve(results)
  });
})

const formatData = () => {
  let concept = getDataPromise('SELECT * FROM `concept` WHERE 1')
  let relation = getDataPromise('SELECT * FROM `relation` WHERE 1')

  return Promise.all([concept, relation]).then(values => {
    const nodes = values[0]
    const links = values[1]

    const size = 50
    const bond = 1

    var data = {
      "nodes" : [],
      "links" : []
    }

    data.nodes.push({}) //FIXME
    nodes.forEach(e => {
      data.nodes.push({
        atom: e.nom,
        size
      })
    })

    links.forEach(e => {
      data.links.push({
        source: e.conceptFrom_id,
        target: e.conceptTo_id,
        bond
      })
    })

    return data
  })
  .catch(err => {
    throw err
  })
}

module.exports = formatData
