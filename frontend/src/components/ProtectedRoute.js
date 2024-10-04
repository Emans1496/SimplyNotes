import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";

function ProtectedRoute({ children }) {
  const [isAuthenticated, setIsAuthenticated] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get("https://simplynotes-backend.onrender.com/api/checkauth.php", { withCredentials: true })
      .then((response) => {
        if (response.data.isAuthenticated) {
          setIsAuthenticated(true);
        } else {
          setIsAuthenticated(false);
          navigate("/");
        }
      })
      .catch((error) => {
        console.error("Errore:", error);
        setIsAuthenticated(false);
        navigate("/");
      });
  }, [navigate]);

  if (isAuthenticated === null) {
    return <div>Caricamento...</div>;
  }

  return isAuthenticated ? children : null;
}

export default ProtectedRoute;
