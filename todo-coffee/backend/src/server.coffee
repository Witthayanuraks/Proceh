express = require 'express'
cors = require 'cors'
bodyParser = require 'body-parser'
app = express()

app.use cors()
app.use bodyParser.json()

# test data memory
todos = [
  {
    id: 1
    title: 'null'
    description: ''
    time: 'null'
    status: 'active'
    category: 'meeting'
    color: '#dbc1ac'
  }
]

# GET all todos with filtering
app.get '/todos', (req, res) ->
  { status, category, q } = req.query
  filtered = todos
  
  if status
    filtered = filtered.filter (todo) -> todo.status is status
  if category and category isnt 'all'
    filtered = filtered.filter (todo) -> todo.category is category
  if q
    searchTerm = q.toLowerCase()
    filtered = filtered.filter (todo) ->
      todo.title.toLowerCase().includes(searchTerm) or 
      todo.description.toLowerCase().includes(searchTerm)
  
  res.json filtered

# GET single todo
app.get '/todos/:id', (req, res) ->
  id = parseInt req.params.id
  todo = todos.find (t) -> t.id is id
  if todo then res.json todo else res.status(404).send 'Not Found'

# POST new todo
app.post '/todos', (req, res) ->
  data = req.body
  newTodo =
    id: Date.now()
    title: data.title
    description: data.description
    time: data.time || '10:30 AM - 12:00 PM'
    status: 'active'
    category: data.category || 'general'
    color: data.color || '#ece0d1'
  
  todos.push newTodo
  res.status(201).json newTodo

# PUT update todo
app.put '/todos/:id', (req, res) ->
  id = parseInt req.params.id
  todo = todos.find (t) -> t.id is id
  
  if todo
    updatableFields = ['title', 'description', 'time', 'status', 'category', 'color']
    updatableFields.forEach (field) ->
      todo[field] = req.body[field] if req.body[field]?
    res.json todo
  else
    res.status(404).send 'Not Found'

# DELETE todo
app.delete '/todos/:id', (req, res) ->
  id = parseInt req.params.id
  index = todos.findIndex (t) -> t.id is id
  
  if index >= 0
    deleted = todos.splice(index, 1)
    res.json deleted[0]
  else
    res.status(404).send 'Not Found'

port = 3000
app.listen port, ->
  console.log "☕️ CoffeeScript 🚶🏼‍♂️‍➡️ http://localhost:#{port}"