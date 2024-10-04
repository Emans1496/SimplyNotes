import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Navigate } from 'react-router-dom';

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
    return null;
  }

  if (isAuthenticated) {
    return children;
  } else {
    return <Navigate to="/" />;
  }
}

export default ProtectedRoute;