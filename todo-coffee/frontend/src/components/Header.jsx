import { Search, Plus, Clock } from 'lucide-react';

export default function Header({
  searchTerm,
  setSearchTerm,
  newTaskTitle,
  setNewTaskTitle,
  newTaskDescription,
  setNewTaskDescription,
  newTaskTime,
  setNewTaskTime,
  handleAddTask
}) {
  return (
    <header className="mb-8">
      <div className="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
          <h2 className="text-2xl font-bold text-coffee-dark">Todo List //</h2>
          <p className="text-sm text-coffee-medium flex items-center gap-1">
            <Clock className="w-3 h-3" />
            21st Feb, 2025
          </p>
        </div>
        
        <div className="flex gap-4">
          <div className="relative">
            <Search className="h-4 w-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-coffee-medium" />
            <input
              type="text"
              placeholder="Search tasks..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="border border-coffee-medium pl-9 pr-3 py-1.5 rounded-md bg-coffee-cream text-coffee-dark placeholder-coffee-medium text-sm w-full md:w-64 focus:outline-none focus:ring-1 focus:ring-coffee-dark"
            />
          </div>
        </div>
      </div>
      
      <div className="bg-coffee-light p-4 rounded-lg shadow-sm mb-6 border border-coffee-medium">
        <h3 className="font-medium mb-3 text-coffee-dark">Add New Task</h3>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label className="block text-sm text-coffee-dark mb-1">Title</label>
            <input
              type="text"
              placeholder="Task title"
              value={newTaskTitle}
              onChange={(e) => setNewTaskTitle(e.target.value)}
              className="border border-coffee-medium px-3 py-1.5 rounded-md bg-coffee-cream text-coffee-dark placeholder-coffee-medium text-sm w-full focus:outline-none focus:ring-1 focus:ring-coffee-dark"
            />
          </div>
          <div>
            <label className="block text-sm text-coffee-dark mb-1">Description</label>
            <input
              type="text"
              placeholder="Task description"
              value={newTaskDescription}
              onChange={(e) => setNewTaskDescription(e.target.value)}
              className="border border-coffee-medium px-3 py-1.5 rounded-md bg-coffee-cream text-coffee-dark placeholder-coffee-medium text-sm w-full focus:outline-none focus:ring-1 focus:ring-coffee-dark"
            />
          </div>
          <div>
            <label className="block text-sm text-coffee-dark mb-1">Time</label>
            <input
              type="text"
              placeholder="10:30 AM - 12:00 PM"
              value={newTaskTime}
              onChange={(e) => setNewTaskTime(e.target.value)}
              className="border border-coffee-medium px-3 py-1.5 rounded-md bg-coffee-cream text-coffee-dark placeholder-coffee-medium text-sm w-full focus:outline-none focus:ring-1 focus:ring-coffee-dark"
            />
          </div>
        </div>
        <button
          onClick={handleAddTask}
          className="mt-4 bg-coffee-dark text-coffee-cream px-4 py-1.5 rounded-md text-sm hover:bg-coffee-espresso flex items-center gap-1"
        >
          <Plus className="w-4 h-4" />
          Add New Task
        </button>
      </div>
    </header>
  );
}