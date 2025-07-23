



import { useEffect, useState } from 'react';
import { Coffee, Calendar, ClipboardList, LayoutGrid, FileText, PenTool, Users, Check, Trash2, Plus, Search, Sun, Clock } from 'lucide-react';

function App() {
  const [todos, setTodos] = useState([]);
  const [newTodo, setNewTodo] = useState({
    title: '',
    description: '',
    time: '10:30 AM - 12:00 PM', // MAYBE YOU CAN ADD SOMEFEATURE LIKE FOR exactly TIME, FOLLOW YOUR TIME ZONE 
    category: 'general'
  });
  const [activeTab, setActiveTab] = useState('active');
  const [selectedCategory, setSelectedCategory] = useState('all');
  const [searchTerm, setSearchTerm] = useState('');

  // Fetch todos
  const fetchTodos = async () => {
    try {
      const params = new URLSearchParams();
      if (activeTab) params.append('status', activeTab);
      if (selectedCategory !== 'all') params.append('category', selectedCategory);
      if (searchTerm) params.append('q', searchTerm);

      const response = await fetch(`http://localhost:3000/todos?${params.toString()}`);
      const data = await response.json();
      setTodos(data);
    } catch (error) {
      console.error('Error fetching todos:', error);
    }
  };

  useEffect(() => {
    fetchTodos();
  }, [activeTab, selectedCategory, searchTerm]);

  const addTodo = async () => {
    if (!newTodo.title.trim()) return;

    try {
      const response = await fetch('http://localhost:3000/todos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(newTodo)
      });
      const data = await response.json();
      setTodos([...todos, data]);
      setNewTodo({
        title: '',
        description: '',
        time: '10:30 AM - 12:00 PM',
        category: 'general'
      });
    } catch (error) {
      console.error('Error adding todo:', error);
    }
  };

  const toggleTodoStatus = async (id) => {
    try {
      const todo = todos.find(t => t.id === id);
      const newStatus = todo.status === 'active' ? 'completed' : 'active';
      
      const response = await fetch(`http://localhost:3000/todos/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus })
      });
      
      if (response.ok) {
        fetchTodos();
      }
    } catch (error) {
      console.error('Error updating todo:', error);
    }
  };

  const deleteTodo = async (id) => {
    try {
      const response = await fetch(`http://localhost:3000/todos/${id}`, {
        method: 'DELETE'
      });
      
      if (response.ok) {
        setTodos(todos.filter(todo => todo.id !== id));
      }
    } catch (error) {
      console.error('Error deleting todo:', error);
    }
  };

  const getCategoryColor = (category) => {
    switch(category) {
      case 'meeting': return 'bg-[#dbc1ac] border-[#967259]';
      case 'planning': return 'bg-[#ece0d1] border-[#967259]';
      case 'report': return 'bg-[#967259] border-[#634832] text-white';
      case 'design': return 'bg-[#634832] border-[#38220f] text-white';
      default: return 'bg-[#ece0d1] border-[#967259]';
    }
  };

  return (
    <div className="flex min-h-screen bg-[#ece0d1] font-sans">
      <aside className="w-64 bg-[#634832] p-6 border-r shadow-sm text-[#ece0d1]">
        <div className="flex items-center gap-2 mb-6">
          <Coffee className="h-6 w-6 text-[#dbc1ac]" />
          <h1 className="text-xl font-bold text-[#dbc1ac]">TaskServe</h1>
        </div>
        
        <nav className="space-y-6 text-sm">
          <div>
            <div className="font-semibold text-[#ece0d1] mb-2 flex items-center gap-2">
              <LayoutGrid className="w-4 h-4" />
              Categories
            </div>
            <ul className="space-y-2">
              {[
                { value: 'all', label: 'All Tasks', icon: <ClipboardList className="w-4 h-4" /> },
                { value: 'meeting', label: 'Meeting', icon: <Calendar className="w-4 h-4" /> },
                { value: 'planning', label: 'Planning', icon: <ClipboardList className="w-4 h-4" /> },
                { value: 'report', label: 'Report', icon: <FileText className="w-4 h-4" /> },
                { value: 'design', label: 'Design', icon: <PenTool className="w-4 h-4" /> }
              ].map(({ value, label, icon }) => (
                <li key={value}>
                  <button
                    onClick={() => setSelectedCategory(value)}
                    className={`w-full text-left px-2 py-1 rounded flex items-center gap-2 ${
                      selectedCategory === value 
                        ? 'bg-[#967259] text-white' 
                        : 'hover:bg-[#38220f] text-[#ece0d1]'
                    }`}
                  >
                    {icon}
                    {label}
                  </button>
                </li>
              ))}
            </ul>
          </div>
        </nav>
      </aside>
      
      <main className="flex-1 p-8">
        <header className="mb-8">
          <div className="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div>
              <h2 className="text-2xl font-bold text-[#634832]">Todo List</h2>
              <p className="text-sm text-[#967259] flex items-center gap-1">
                <Clock className="w-3 h-3" />
                {new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' })}
              </p>
            </div>
            
            <div className="flex gap-4">
              <div className="relative">
                <Search className="h-4 w-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-[#967259]" />
                <input
                  type="text"
                  placeholder="Search tasks..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="border border-[#967259] pl-9 pr-3 py-1.5 rounded-md bg-[#ece0d1] text-[#634832] placeholder-[#967259] text-sm w-full md:w-64 focus:outline-none focus:ring-1 focus:ring-[#634832]"
                />
              </div>
            </div>
          </div>
          
          <div className="bg-[#dbc1ac] p-4 rounded-lg shadow-sm mb-6 border border-[#967259]">
            <h3 className="font-medium mb-3 text-[#634832]">Add New Task</h3>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div>
                <label className="block text-sm text-[#634832] mb-1">Title</label>
                <input
                  type="text"
                  placeholder="Task title"
                  value={newTodo.title}
                  onChange={(e) => setNewTodo({...newTodo, title: e.target.value})}
                  className="border border-[#967259] px-3 py-1.5 rounded-md bg-[#ece0d1] text-[#634832] placeholder-[#967259] text-sm w-full focus:outline-none focus:ring-1 focus:ring-[#634832]"
                />
              </div>
              <div>
                <label className="block text-sm text-[#634832] mb-1">Description</label>
                <input
                  type="text"
                  placeholder="Task description"
                  value={newTodo.description}
                  onChange={(e) => setNewTodo({...newTodo, description: e.target.value})}
                  className="border border-[#967259] px-3 py-1.5 rounded-md bg-[#ece0d1] text-[#634832] placeholder-[#967259] text-sm w-full focus:outline-none focus:ring-1 focus:ring-[#634832]"
                />
              </div>
              <div>
                <label className="block text-sm text-[#634832] mb-1">Category</label>
                <select
                  value={newTodo.category}
                  onChange={(e) => setNewTodo({...newTodo, category: e.target.value})}
                  className="border border-[#967259] px-3 py-1.5 rounded-md bg-[#ece0d1] text-[#634832] text-sm w-full focus:outline-none focus:ring-1 focus:ring-[#634832]"
                >
                  <option value="general">General</option>
                  <option value="meeting">Meeting</option>
                  <option value="planning">Planning</option>
                  <option value="report">Report</option>
                  <option value="design">Design</option>
                </select>
              </div>
            </div>
            <button
              onClick={addTodo}
              className="mt-4 bg-[#634832] text-[#ece0d1] px-4 py-1.5 rounded-md text-sm hover:bg-[#38220f] flex items-center gap-1"
            >
              <Plus className="w-4 h-4" />
              Add New Task
            </button>
          </div>
        </header>
        
        <div className="flex gap-4 mb-6">
          <button 
            onClick={() => setActiveTab('active')}
            className={`flex items-center gap-1 font-medium pb-1 ${
              activeTab === 'active' 
                ? 'text-[#634832] border-b-2 border-[#634832]' 
                : 'text-[#967259]'
            }`}
          >
            <Sun className="w-4 h-4" />
            Active Task
          </button>
          <button 
            onClick={() => setActiveTab('completed')}
            className={`flex items-center gap-1 font-medium pb-1 ${
              activeTab === 'completed' 
                ? 'text-[#634832] border-b-2 border-[#634832]' 
                : 'text-[#967259]'
            }`}
          >
            <Check className="w-4 h-4" />
            Completed
          </button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {todos.length > 0 ? (
            todos.map((todo) => (
              <div 
                key={todo.id}
                className={`${getCategoryColor(todo.category)} p-4 rounded-xl shadow-sm border hover:border-[#634832] transition-all`}
              >
                <div className="flex justify-between items-start mb-2">
                  <h3 className={`font-semibold ${todo.status === 'completed' ? 'line-through text-[#967259]' : ''}`}>
                    {todo.title}
                  </h3>
                  <div className="flex gap-2">
                    <button 
                      onClick={() => toggleTodoStatus(todo.id)}
                      className={`flex items-center gap-1 text-xs px-2 py-1 rounded ${
                        todo.status === 'completed' 
                          ? 'bg-[#967259] text-[#ece0d1]' 
                          : 'bg-[#634832] text-[#ece0d1] hover:bg-[#38220f]'
                      }`}
                    >
                      {todo.status === 'completed' ? (
                        <>
                          <Check className="w-3 h-3" />
                          Done
                        </>
                      ) : 'Mark Complete'}
                    </button>
                    <button 
                      onClick={() => deleteTodo(todo.id)}
                      className="text-xs px-2 py-1 rounded bg-[#38220f] text-[#ece0d1] hover:bg-[#634832] flex items-center gap-1"
                    >
                      <Trash2 className="w-3 h-3" />
                    </button>
                  </div>
                </div>
                <p className={`text-sm mb-3 ${todo.status === 'completed' ? 'line-through text-[#967259]' : ''}`}>
                  {todo.description}
                </p>
                <div className="flex justify-between items-center">
                  <p className={`text-sm font-medium flex items-center gap-1 ${
                    todo.status === 'completed' ? 'text-[#967259]' : 'text-[#634832]'
                  }`}>
                    <Clock className="w-3 h-3" />
                    {todo.time}
                  </p>
                  <span className={`text-xs px-2 py-1 rounded-full ${
                    todo.status === 'completed' ? 'bg-[#ece0d1] text-[#634832]' : 'bg-[#634832] text-[#ece0d1]'
                  }`}>
                    {todo.status === 'completed' ? 'Finished' : 'Brewing'}
                  </span>
                </div>
              </div>
            ))
          ) : (
            <div className="col-span-3 text-center py-10 text-[#967259] flex flex-col items-center">
              <Coffee className="w-12 h-12 mb-4 text-[#dbc1ac]" />
              <p>No tasks found. Enjoy your coffee break!</p>
            </div>
          )}
        </div>
      </main>
    </div>
  );
}

export default App;