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

//Helper 1: Gets the excerpt
const getExcerpt = (htmlString: string, maxLength: number) => {
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = htmlString;
  const plainText = tempDiv.textContent || tempDiv.innerText || "";
  
  if (plainText.length <= maxLength) return plainText;
  return plainText.substring(0, maxLength).trim() + "...";
};

//Helper 2: Checks if an article needs a "Read full article" button
const checkNeedsButton = (htmlString: string, maxLength: number) => {
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = htmlString;
  const plainText = tempDiv.textContent || tempDiv.innerText || "";
  return plainText.length > maxLength;
};

function App() {
  const [articles, setArticles] = useState<Article[]>([]);
  const [error, setError] = useState("");

  const [expandedArticleId, setExpandedArticleId] = useState<number | null>(null);

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

  const toggleArticle = (id: number) => {
    if (expandedArticleId === id) {
      setExpandedArticleId(null);
    } else {
      setExpandedArticleId(id);
    }
  };

  return (
    <div className="min-vh-100">
      
      <header className="shadow-sm" style={{ backgroundColor: '#202938' }}>
        <div className="container-fluid py-3 px-4">
          <h2 className="h5 fw-semibold mb-0 py-2 text-start" style={{ color: 'white' }}>
            Latest Articles
          </h2>
        </div>
      </header>

      <main className="py-5">
        <div className="container px-sm-4 px-lg-5" style={{ maxWidth: '80rem' }}>
          
          {error && <div className="alert alert-danger shadow-sm text-start">{error}</div>}

          <div className="card border-0 shadow-sm" style={{ borderRadius: '0.5rem' }}>
            <div className="card-body p-4 p-lg-5">

              <div className="d-flex flex-column gap-3">
                {articles.map((article) => {
                  const isExpanded = expandedArticleId === article.id;
                  
                  const needsButton = checkNeedsButton(article.content, 500);

                  return (
                    <div className="border rounded shadow-sm p-4 bg-white" key={article.id}>
                      
                      <div className="mb-3 border-bottom pb-2 text-start">
                        <h4 className="fw-bold fs-5 mb-1 text-dark">{article.title}</h4>
                        <p className="text-muted small mb-0">
                          Posted: {new Date(article.created_at).toLocaleDateString()}
                        </p>
                      </div>
                      
                      {(!needsButton || isExpanded) ? (
                        <div
                          className="card-text text-dark text-start mt-3"
                          style={{ lineHeight: '1.8' }}
                          dangerouslySetInnerHTML={{ __html: article.content }}
                        />
                      ) : (
                        <p className="card-text text-secondary text-start mt-3" style={{ lineHeight: '1.6' }}>
                          {getExcerpt(article.content, 500)}
                        </p>
                      )}

                      {needsButton && (
                        <div className="text-start mt-4 border-top pt-3">
                          <button 
                            onClick={() => toggleArticle(article.id)}
                            className="btn btn-link text-primary fw-bold text-decoration-none p-0" 
                            style={{ fontSize: '0.95rem' }}
                          >
                            {isExpanded ? 'Show less' : 'Read full article'}
                          </button>
                        </div>
                      )}

                    </div>
                  );
                })}
              </div>

            </div>
          </div>

        </div>
      </main>
    </div>
  );
}

export default App;