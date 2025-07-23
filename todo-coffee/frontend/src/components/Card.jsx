import { Check, Trash2, Clock } from 'lucide-react';

export default function Card({
  title,
  description,
  time,
  color,
  completed,
  onToggleComplete,
  onDelete
}) {
  return (
    <div className={`${color} p-4 rounded-xl shadow-sm border hover:border-coffee-dark transition-all`}>
      <div className="flex justify-between items-start mb-2">
        <h3 className={`font-semibold ${completed ? 'line-through text-coffee-medium' : ''}`}>
          {title}
        </h3>
        <div className="flex gap-2">
          <button 
            onClick={onToggleComplete}
            className={`flex items-center gap-1 text-xs px-2 py-1 rounded ${
              completed 
                ? 'bg-coffee-medium text-coffee-cream' 
                : 'bg-coffee-dark text-coffee-cream hover:bg-coffee-espresso'
            }`}
          >
            {completed ? (
              <>
                <Check className="w-3 h-3" />
                Done
              </>
            ) : 'Mark Complete'}
          </button>
          <button 
            onClick={onDelete}
            className="text-xs px-2 py-1 rounded bg-coffee-espresso text-coffee-cream hover:bg-coffee-dark flex items-center gap-1"
          >
            <Trash2 className="w-3 h-3" />
          </button>
        </div>
      </div>
      <p className={`text-sm mb-3 ${completed ? 'line-through text-coffee-medium' : ''}`}>
        {description}
      </p>
      <div className="flex justify-between items-center">
        <p className={`text-sm font-medium flex items-center gap-1 ${
          completed ? 'text-coffee-medium' : 'text-coffee-dark'
        }`}>
          <Clock className="w-3 h-3" />
          {time}
        </p>
        <span className={`text-xs px-2 py-1 rounded-full ${
          completed ? 'bg-coffee-cream text-coffee-dark' : 'bg-coffee-dark text-coffee-cream'
        }`}>
          {completed ? 'Finished' : 'Brewing'}
        </span>
      </div>
    </div>
  );
}