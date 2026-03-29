import { useEffect, useState } from "react";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";

type Article = {
  id: number;
  title: string;
  content: string;
  created_at: string;
  updated_at: string;
};

function App() {
  const [articles, setArticles] = useState<Article[]>([]);
  const [error, setError] = useState("");

  useEffect(() => {
    axios
      .get<Article[]>("http://127.0.0.1:8000/api/articles")
      .then((res) => {
        const sorted = res.data.sort(
          (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
        );
        setArticles(sorted);
      })
      .catch((err) => {
        console.error(err);
        setError("Could not load articles from the server.");
      });
  }, []);

  return (
    <div className="container border-0 mt-5">
      <h1 className="text-center mb-5 fw-bold">Latest Articles</h1>
      {error && <div className="alert alert-danger">{error}</div>}

      {articles.map((article) => (
        <div className="card mb-4 shadow-lg border-0 p-4" key={article.id}>
          <div className="card-body">
            <h3 className="card-title">{article.title}</h3>
            
            {/* Renders the HTML content safely from the database */}
            <div
              className="card-text mt-3"
              dangerouslySetInnerHTML={{ __html: article.content }}
            />
            
            <p className="text-muted mt-3 mb-0" style={{ fontSize: '0.85rem' }}>
              Posted: {new Date(article.created_at).toLocaleDateString()}
            </p>
          </div>
        </div>
      ))}
    </div>
  );
}

export default App;