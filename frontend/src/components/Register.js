import React, { useState } from "react";
import axios from "axios";
import { useNavigate, Link } from "react-router-dom";

function Register() {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState("");
  const [email, setEmail] = useState("");
  const [success, setSuccess] = useState(null);
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();

    const formData = new FormData();
    formData.append("username", username);
    formData.append("email", email);
    formData.append("password", password);

    axios
      .post(
        "https://simplynotes-backend.onrender.com/api/register.php",
        formData
      )
      .then((response) => {
        console.log(response.data);
        setSuccess(response.data.success);
        setMessage(response.data.message);
        if (response.data.success) {
          navigate("/");
        }
      })
      .catch((error) => {
        console.error("Errore:", error);
      });
  };

  return (
    <div className="container mt-5">
      <div className="row justify-content-center">
        <div className="col-md-6">
          <h2 className="text-center">Registrazione</h2>
          {message && (
            <div
              className={`alert ${success ? "alert-success" : "alert-danger"}`}
            >
              {message}
            </div>
          )}
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
              <label className="form-label">Email</label>
              <input
                type="email"
                className="form-control"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required // Rendi il campo obbligatorio se necessario
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
              Registrati
            </button>
          </form>
          <p className="mt-3 text-center">
            Hai già un account? <Link to="/">Accedi qui</Link>
          </p>
        </div>
      </div>
    </div>
  );
}

export default Register;
