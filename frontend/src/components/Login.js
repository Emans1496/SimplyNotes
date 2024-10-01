import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate, Link } from 'react-router-dom';

function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

    axios
      .post('https://simplynotes-backend.onrender.com/api/login.php', formData, { withCredentials: true })
      .then((response) => {
        if (response.data.success) {
          navigate('/dashboard');
        } else {
          setMessage(response.data.message);
        }
      })
      .catch((error) => {
        console.error('Errore:', error);
      });
  };

  return (
    <div className="container mt-5">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <h2 className="text-center">Login</h2>
          {message && <div className="alert alert-danger">{message}</div>}
          <form onSubmit={handleSubmit}>
            <div className="mb-3">
              <label className="form-label">Username</label>
              <input
                type="text"
                className="form-control"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                required
              />
            </div>
            <div className="mb-3">
              <label className="form-label">Password</label>
              <input
                type="password"
                className="form-control"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
            </div>
            <button type="submit" className="btn btn-primary w-100">
              Accedi
            </button>
          </form>
          <p className="mt-3 text-center">
            Non hai un account? <Link to="/register">Registrati qui</Link>
          </p>
        </div>
      </div>
    </div>
  );
}

export default Login;
