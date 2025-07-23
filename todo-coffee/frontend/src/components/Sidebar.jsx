import { Coffee, Calendar, ClipboardList, LayoutGrid, FileText, PenTool, Users } from 'lucide-react';

export default function Sidebar({ selectedCategory, setSelectedCategory }) {
  return (
    <aside className="w-64 bg-coffee-dark p-6 border-r shadow-sm text-coffee-cream">
      <div className="flex items-center gap-2 mb-6">
        <Coffee className="h-6 w-6 text-coffee-light" />
        <h1 className="text-xl font-bold text-coffee-light">TaskServe</h1>
      </div>
      
      <nav className="space-y-6 text-sm">
        <div>
          <div className="font-semibold text-coffee-cream mb-2 flex items-center gap-2">
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
                      ? 'bg-coffee-medium text-white' 
                      : 'hover:bg-coffee-espresso text-coffee-cream'
                  }`}
                >
                  {icon}
                  {label}
                </button>
              </li>
            ))}
          </ul>
        </div>

        <div>
          <div className="font-semibold text-coffee-cream mb-2 flex items-center gap-2">
            <PenTool className="w-4 h-4" />
            Coffee Tools
          </div>
          <ul className="ml-4 space-y-2">
            <li className="flex items-center gap-2 hover:text-coffee-light cursor-pointer">
              <Calendar className="w-4 h-4" />
              <span>Team Meeting</span>
            </li>
            <li className="flex items-center gap-2 hover:text-coffee-light cursor-pointer">
              <LayoutGrid className="w-4 h-4" />
              <span>Work on Branding</span>
            </li>
            <li className="flex items-center gap-2 hover:text-coffee-light cursor-pointer">
              <FileText className="w-4 h-4" />
              <span>Make a Report</span>
            </li>
            <li className="flex items-center gap-2 hover:text-coffee-light cursor-pointer">
              <ClipboardList className="w-4 h-4" />
              <span>Create a planer</span>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
  );
}