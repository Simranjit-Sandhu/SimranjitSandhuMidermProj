<!--
    Name: Simranjit Sandhu
    Class: INF653
    Date: March 28, 2026
    Project: Quotations REST API built with PHP and PostgreSQL, providing CRUD endpoints for quotes, authors, and categories.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotations API</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .api-section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 20px;
            color: #667eea;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .endpoint {
            background: #f5f5f5;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
            border-radius: 4px;
        }

        .method {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            margin-right: 10px;
            color: white;
            font-size: 12px;
        }

        .method.get {
            background: #61affe;
        }

        .method.post {
            background: #49cc90;
        }

        .method.put {
            background: #fca130;
        }

        .method.delete {
            background: #f93e3e;
        }

        .url {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 8px 12px;
            border-radius: 4px;
            color: #d63384;
            display: inline-block;
            margin-top: 5px;
        }

        .description {
            color: #666;
            margin-top: 8px;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            color: #666;
            margin-top: 40px;
            font-size: 12px;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .quick-links {
            background: #f0f4ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .quick-links h3 {
            color: #667eea;
            margin-bottom: 15px;
        }

        .quick-links a {
            display: inline-block;
            margin-right: 15px;
            padding: 8px 16px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            transition: background 0.3s;
        }

        .quick-links a:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Quotations REST API</h1>
        <p class="subtitle">A PHP OOP REST API for managing famous quotes and user submissions</p>

        <div class="quick-links">
            <h3>Quick Access</h3>
            <a href="api/quotes/">Get All Quotes</a>
            <a href="api/authors/">Get All Authors</a>
            <a href="api/categories/">Get All Categories</a>
        </div>

        <!-- Quotes Endpoints -->
        <div class="api-section">
            <div class="section-title">📖 Quotes Endpoints</div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/quotes/</div>
                <div class="description">Get all quotes</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/quotes/?id=1</div>
                <div class="description">Get a specific quote by ID</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/quotes/?author_id=1</div>
                <div class="description">Get all quotes by a specific author</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/quotes/?category_id=1</div>
                <div class="description">Get all quotes in a specific category</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/quotes/?author_id=1&category_id=1</div>
                <div class="description">Get quotes by author and category</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/quotes/?random=true</div>
                <div class="description">Get a random quote</div>
            </div>

            <div class="endpoint">
                <span class="method post">POST</span>
                <div class="url">/api/quotes/</div>
                <div class="description">Create a new quote (requires: quote, author_id, category_id)</div>
            </div>

            <div class="endpoint">
                <span class="method put">PUT</span>
                <div class="url">/api/quotes/</div>
                <div class="description">Update a quote (requires: id, quote, author_id, category_id)</div>
            </div>

            <div class="endpoint">
                <span class="method delete">DELETE</span>
                <div class="url">/api/quotes/</div>
                <div class="description">Delete a quote (requires: id)</div>
            </div>
        </div>

        <!-- Authors Endpoints -->
        <div class="api-section">
            <div class="section-title">✍️ Authors Endpoints</div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/authors/</div>
                <div class="description">Get all authors</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/authors/?id=1</div>
                <div class="description">Get a specific author by ID</div>
            </div>

            <div class="endpoint">
                <span class="method post">POST</span>
                <div class="url">/api/authors/</div>
                <div class="description">Create a new author (requires: author)</div>
            </div>

            <div class="endpoint">
                <span class="method put">PUT</span>
                <div class="url">/api/authors/</div>
                <div class="description">Update an author (requires: id, author)</div>
            </div>

            <div class="endpoint">
                <span class="method delete">DELETE</span>
                <div class="url">/api/authors/</div>
                <div class="description">Delete an author (requires: id)</div>
            </div>
        </div>

        <!-- Categories Endpoints -->
        <div class="api-section">
            <div class="section-title">🏷️ Categories Endpoints</div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/categories/</div>
                <div class="description">Get all categories</div>
            </div>

            <div class="endpoint">
                <span class="method get">GET</span>
                <div class="url">/api/categories/?id=1</div>
                <div class="description">Get a specific category by ID</div>
            </div>

            <div class="endpoint">
                <span class="method post">POST</span>
                <div class="url">/api/categories/</div>
                <div class="description">Create a new category (requires: category)</div>
            </div>

            <div class="endpoint">
                <span class="method put">PUT</span>
                <div class="url">/api/categories/</div>
                <div class="description">Update a category (requires: id, category)</div>
            </div>

            <div class="endpoint">
                <span class="method delete">DELETE</span>
                <div class="url">/api/categories/</div>
                <div class="description">Delete a category (requires: id)</div>
            </div>
        </div>

        <div class="footer">
            <p>💡 Use <a href="https://www.postman.com/" target="_blank">Postman</a> to test the API endpoints</p>
            <p style="margin-top: 10px;">© 2024 Quotations API | Built with PHP OOP</p>
        </div>
    </div>
</body>
</html>
