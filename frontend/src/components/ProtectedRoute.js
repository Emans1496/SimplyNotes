import React, { useEffect, useState } from 'react';
import { Navigate } from 'react-router-dom';
import axios from 'axios';

function ProtectedRoute({ children }) {
  const [isAuthenticated, setIsAuthenticated] = useState(null);

  useEffect(() => {
    axios
      .get('https://simplynotes-backend.onrender.com/api/check_auth.php', {
        withCredentials: true,
      })
      .then((response) => {
        setIsAuthenticated(response.data.isAuthenticated);
      })
      .catch((error) => {
        console.error('Errore durante la verifica dell\'autenticazione:', error);
        setIsAuthenticated(false);
      });
  }, []);

  if (isAuthenticated === null) {
    return <div>Caricamento...</div>;
  }

  return isAuthenticated ? children : <Navigate to="/" />;
}

export default ProtectedRoute;
