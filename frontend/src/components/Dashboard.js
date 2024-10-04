import React, { useState } from 'react';
// import axios from 'axios'; // commentato temporaneamente
import { useNavigate } from 'react-router-dom';
import Note from './Note';

function Dashboard() {
  const [notes, setNotes] = useState([
    { id: 1, title: "Nota 1", content: "Contenuto della nota 1" },
    { id: 2, title: "Nota 2", content: "Contenuto della nota 2" },
  ]);
  const [title, setTitle] = useState('');
  const [content, setContent] = useState('');
  const [message, setMessage] = useState('');
  const navigate = useNavigate();

  // Elimina il useEffect per il caricamento delle note

  const handleLogout = () => {
    // Elimina la logica di logout
    localStorage.removeItem('user_id');
    navigate('/');
  };

  const handleAddNote = (e) => {
    e.preventDefault();
    const newNote = { id: notes.length + 1, title, content };
    setNotes([...notes, newNote]);
    setTitle('');
    setContent('');
  };

  return (
    <div className="container mt-5">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard</h2>
        <button className="btn btn-secondary" onClick={handleLogout}>
          Logout
        </button>
      </div>
      {message && <div className="alert alert-success">{message}</div>}
      <form onSubmit={handleAddNote} className="mb-4">
        <h3>Aggiungi una nuova nota</h3>
        <div className="mb-3">
          <label className="form-label">Titolo</label>
          <input
            type="text"
            className="form-control"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            required
          />
        </div>
        <div className="mb-3">
          <label className="form-label">Contenuto</label>
          <textarea
            className="form-control"
            value={content}
            onChange={(e) => setContent(e.target.value)}
            required
          />
        </div>
        <button type="submit" className="btn btn-primary">
          Aggiungi Nota
        </button>
      </form>
      <h3>Le tue note</h3>
      {notes.length > 0 ? (
        <div className="row">
          {notes.map((note) => (
            <Note key={note.id} note={note} refreshNotes={() => {}} />
          ))}
        </div>
      ) : (
        <p>Non hai ancora note.</p>
      )}
    </div>
  );
}

export default Dashboard;
