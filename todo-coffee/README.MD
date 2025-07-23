# ☕ TaskServe - A Coffee-Themed Todo List


A full-stack todo list application with a cozy coffee theme, featuring a CoffeeScript backend and React frontend with Lucide icons.


## Features

### Backend (CoffeeScript)
- RESTful API with CRUD operations
- In-memory data storage
- Filtering by status, category, and search term
- CORS enabled for frontend integration
- Coffee-themed initial data

### Frontend (React Vite)
- ☕ Coffee color palette (#ece0d1, #dbc1ac, #967259, #634832, #38220f)
- 📝 Full CRUD functionality 
- 🔍 Real-time filtering and search
- 🏷️ Category-based task organization
- ✅ Status toggling (active/complete)
- ✨ Lucide React icons throughout
- 📱 Responsive design

## Tech Stack

**Backend:**
- Node.js
- Express
- CoffeeScript
- CORS middleware
- Body-parser

**Frontend:**
- React Vite
- Tailwind CSS (v4 latest)
- Lucide React icons
- Fetch API

## Installation

### Backend Setup

1. Ensure you have Node.js and npm installed
2. Install CoffeeScript globally:
   ```bash
   npm install -g coffeescript
   ```
3. Navigate to backend directory:
   ```bash
   cd backend
   ```
4. Install dependencies:
   ```bash
   npm install express cors body-parser
   ```
5. Run the backend server:
   ```bash
   coffee server.coffee
   ```
   Server will run at `http://localhost:3000`

### Frontend Setup

1. Navigate to frontend directory:
   ```bash
   cd frontend
   ```
2. Install dependencies:
   ```bash
   npm install lucide-react @tailwindcss/postcss7-compat postcss autoprefixer
   ```
3. Start the development server:
   ```bash
   npm start
   ```
   App will run at `http://localhost:3001`

## API Endpoints

| Method | Endpoint       | Description                     |
|--------|----------------|---------------------------------|
| GET    | /todos         | Get all todos (with filters)    |
| GET    | /todos/:id     | Get single todo                 |
| POST   | /todos         | Create new todo                 |
| PUT    | /todos/:id     | Update todo                     |
| DELETE | /todos/:id     | Delete todo                     |

**Query Parameters:**
- `status` - Filter by status (active/completed)
- `category` - Filter by category
- `q` - Search term

## Project Structure

```
task-coffee/
├── backend/
│   ├── server.coffee    # CoffeeScript backend
│   └── package.json     # Backend dependencies
└── frontend/
    ├── src/
    │   ├── App.jsx      # Main React component
    │   └── ...          # Other React components
    └── package.json     # Frontend dependencies
```

## Color Palette

| Color       | Hex       | Usage                      |
|-------------|-----------|----------------------------|
| Cream       | #ece0d1   | Background, light elements |
| Light Coffee| #dbc1ac   | Cards, accents             |
| Medium Coffee| #967259  | Text, borders              |
| Dark Coffee | #634832   | Headers, buttons           |
| Espresso    | #38220f   | Dark accents               |

## Available Scripts

In the frontend directory, you can run:

- `npm start` - Runs the app in development mode
- `npm test` - Launches the test runner
- `npm run build` - Builds the app for production

## Future Enhancements [JUST IDEA]

- [ ] Add user authentication
- [ ] Implement persistent database (MongoDB/PostgreSQL)
- [ ] Add drag-and-drop reordering
- [ ] Implement dark/light mode toggle
- [ ] Add task due dates and reminders

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you'd like to change. 👏👏👏

