// src/pages/TodoPage.jsx
import Sidebar from '../components/Sidebar'
import Header from '../components/Header'
import Card from '../components/Card'

export default function TodoPage() {
  return (
    <div className="flex min-h-screen bg-gray-100 font-sans">
      <Sidebar />
      <main className="flex-1 p-8">
        <Header />
        <div className="flex gap-4 mb-4">
          <button className="text-blue-600 font-medium border-b-2 border-blue-600 pb-1">
            Active Task
          </button>
          <button className="text-gray-500 font-medium pb-1">Completed</button>
        </div>
        <div className="grid grid-cols-3 gap-6">
            <Card key={task.id} title={task.title} color="bg-blue-100" time={task.time} />
          <Card title="Team Meeting" color="bg-blue-100" />
          <Card title="Work on Branding" color="bg-purple-100" />
          <Card title="Make a Report for client" color="bg-yellow-100" />
          <Card title="Create a planer" color="bg-pink-100" />
          <Card title="Create Treatment Plan" color="bg-green-100" />
        </div>
      </main>
    </div>
  );
}