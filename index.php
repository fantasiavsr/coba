<?php
require_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
</head>

<body style="background-color: #f1f3f6">
  <div id="root"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.development.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.development.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.21.1/babel.min.js"></script>

  <script type="text/babel">

      function BookRegistration({ onRegister }) {
        const [title, setTitle] = React.useState("");
        const [author, setAuthor] = React.useState("");

        const handleSubmit = (e) => {
          e.preventDefault();
          // Create a FormData object to send the form data
          const formData = new FormData();
          formData.append("title", title);
          formData.append("author", author);

          // Send the form data to the server using fetch
          fetch("process-form.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.json())
            .then((data) => {
              // Handle the response from the server
              if (data.success) {
                // If the server returns a success message
                onRegister({ title, author });
                setTitle("");
                setAuthor("");
                alert("Buku berhasil didaftarkan");
              } else {
                // If the server returns an error message
                alert("Gagal menyimpan buku ke database");
              }
            })
            .catch((error) => {
              // Handle any errors that occur during the request
              console.error("Error:", error);
            });
        };

        return (
          <div className="card">
            <div className="card-body">
              <h5 className="card-title">Pendaftaran Buku</h5>

              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="title" className="form-label">
                    Judul Buku
                  </label>
                  <input
                    type="text"
                    className="form-control"
                    id="title"
                    name="title"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                    required
                  />
                </div>
                <div className="mb-3">
                  <label htmlFor="author" className="form-label">
                    Penulis Buku
                  </label>
                  <input
                    type="text"
                    className="form-control"
                    id="author"
                    name="author"
                    value={author}
                    onChange={(e) => setAuthor(e.target.value)}
                    required
                  />
                </div>
                <button type="submit" className="btn btn-primary">
                  Daftarkan Buku
                </button>
              </form>

            </div>
          </div>
        );
      }

      function BookBorrow({ books, onBorrow }) {
        const [selectedBook, setSelectedBook] = React.useState("");

        const handleSubmit = (e) => {
          e.preventDefault();
          const book = books.find((book) => book.id === selectedBook);

          if (book) {
             // Create a FormData object to send the form data
            const formData = new FormData();
            formData.append("id", book.id);
            formData.append("title", book.title);
            formData.append("author", book.author);

            // Send the form data to the server using fetch
            fetch("borrow-book.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((data) => {
                // Handle the response from the server
                if (data.success) {
                  // If the server returns a success message
                  onRegister({ title, author });
                  setTitle("");
                  setAuthor("");
                  alert("Buku berhasil dipinjam");
                } else {
                  // If the server returns an error message
                  alert("Gagal mememinjam");
                }
              })
              .catch((error) => {
                // Handle any errors that occur during the request
                console.error("Error:", error);
              });
              
            } else {
            alert("Buku with ID " + selectedBook + " tidak ditemukan");
          }
        };

        return (
          <div className="card">
            <div className="card-body">
              <h5 className="card-title">Peminjaman Buku</h5>
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="book" className="form-label">
                    Pilih Buku
                  </label>
                  <select
                    className="form-select"
                    id="book"
                    name="book"
                    value={selectedBook}
                    onChange={(e) => setSelectedBook(e.target.value)}
                    required
                  >
                    <option value="">Pilih buku</option>
                      {books.map((book) => (
                        <option key={book.id} value={book.id}>
                          {book.id} {book.title}
                        </option>
                      ))}
                  </select>
                </div>
                <button type="submit" className="btn btn-primary">
                  Pinjam Buku
                </button>
              </form>
            </div>
          </div>
        );
      }

      function BookReturn({ borrowedBooks, onReturn }) {
        const [selectedBook, setSelectedBook] = React.useState("");

        const handleSubmit = (e) => {
          e.preventDefault();
         
          const book = borrowedBooks.find((book) => book.id === selectedBook);
          
          if (book) {
            // Create a FormData object to send the form data
            const formData = new FormData();
            formData.append("id", book.id);

            // Send the form data to the server using fetch
            fetch("return-book.php", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((data) => {
                // Handle the response from the server
                if (data.success) {
                  // If the server returns a success message
                  onRegister({ title, author });
                  setTitle("");
                  setAuthor("");
                  alert("Buku berhasil dikembalikan");
                } else {
                  // If the server returns an error message
                  alert("Gagal mengembalikan");
                }
              })
              .catch((error) => {
                // Handle any errors that occur during the request
                console.error("Error:", error);
              });
          } else {
            alert("Buku with ID " + selectedBook + " tidak ditemukan");
          }
        };

        return (
          <div className="card">
            <div className="card-body">
              <h5 className="card-title">Pengembalian Buku</h5>
              <form onSubmit={handleSubmit}>
                <div className="mb-3">
                  <label htmlFor="book" className="form-label">
                    Pilih Buku
                  </label>
                  <select
                    className="form-select"
                    id="book"
                    name="book"
                    value={selectedBook}
                    onChange={(e) => setSelectedBook(e.target.value)}
                    required
                  >
                    <option value="">Pilih buku</option>
                    {borrowedBooks.map((book) => (
                      <option key={book.id} value={book.id}>
                        {book.title}
                      </option>
                    ))}
                  </select>
                </div>
                <button type="submit" className="btn btn-primary">
                  Kembalikan Buku
                </button>
              </form>
            </div>
          </div>
        );
      }

      function BookList({ books, borrowedBooks }) {
        return (
          <div className="card">
            <div className="card-body">
              <h5 className="card-title">List Buku</h5>
              <div>
                <h6>Buku Terdaftar: {books.length}</h6>
                <ul>
                  {books.map((book) => (
                    <li key={book.id}>{book.title}</li>
                  ))}
                </ul>
              </div>
              <div>
                <h6>Buku Dipinjam: {borrowedBooks.length}</h6>
                <ul>
                  {borrowedBooks.map((book) => (
                    <li key={book.id}>{book.title}</li>
                  ))}
                </ul>
              </div>
            </div>
          </div>
        );
      }

      function App() {
        const [activeMenu, setActiveMenu] = React.useState("registration");
        const [books, setBooks] = React.useState([]);
        const [borrowedBooks, setBorrowedBooks] = React.useState([]);

        // Fetch book data from the server
        React.useEffect(() => {
        // Fetch book data from the server
        fetch("fetch-books.php")
          .then((response) => response.json())
          .then((data) => {
            // Update the books state with the fetched data
            setBooks(data.books);
          })
          .catch((error) => {
            console.error("Error:", error);
          });
        }, [],
        // Fetch borrowed book data from the server
        React.useEffect(() => {
          fetch("fetch-borrowed-books.php")
            .then((response) => response.json())
            .then((data) => {
              // Update the borrowedBooks state with the fetched data
              setBorrowedBooks(data.books);
            })
            .catch((error) => {
              console.error("Error:", error);
            });
        }, []));
        
        const handleRegisterBook = (newBook) => {
          const book = { ...newBook, id: Date.now() };
          setBooks((prevBooks) => [...prevBooks, book]);
        };

        const handleBorrowBook = (book) => {
          setBooks((prevBooks) => prevBooks.filter((b) => b.id !== book.id));
          setBorrowedBooks((prevBorrowedBooks) => [...prevBorrowedBooks, book]);
        };

        const handleReturnBook = (book) => {
          setBorrowedBooks((prevBorrowedBooks) =>
            prevBorrowedBooks.filter((b) => b.id !== book.id)
          );
          setBooks((prevBooks) => [...prevBooks, book]);
        };

        let content;
        if (activeMenu === "registration") {
          content = <BookRegistration onRegister={handleRegisterBook} />;
        } else if (activeMenu === "borrow") {
          content = <BookBorrow books={books} onBorrow={handleBorrowBook} />;
        } else if (activeMenu === "return") {
          content = (
            <BookReturn
              borrowedBooks={borrowedBooks}
              onReturn={handleReturnBook}
            />
          );
        } else if (activeMenu === "list") {
          content = <BookList books={books} borrowedBooks={borrowedBooks} />;
        }

        return (
          <div className="container mt-5">
            <nav className="navbar navbar-expand-lg navbar-light bg-light mb-3">
              <div className="container-fluid">
                <span className="navbar-brand">Perpustakaan</span>
                <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                  <li className="nav-item">
                    <button
                      className={`nav-link btn ${
                        activeMenu === "registration" ? "active" : ""
                      }`}
                      onClick={() => setActiveMenu("registration")}
                    >
                      Pendaftaran Buku
                    </button>
                  </li>
                  <li className="nav-item">
                    <button
                      className={`nav-link btn ${
                        activeMenu === "borrow" ? "active" : ""
                      }`}
                      onClick={() => setActiveMenu("borrow")}
                    >
                      Peminjaman Buku
                    </button>
                  </li>
                  <li className="nav-item">
                    <button
                      className={`nav-link btn ${
                        activeMenu === "return" ? "active" : ""
                      }`}
                      onClick={() => setActiveMenu("return")}
                    >
                      Pengembalian Buku
                    </button>
                  </li>
                  <li className="nav-item">
                    <button
                      className={`nav-link btn ${
                        activeMenu === "list" ? "active" : ""
                      }`}
                      onClick={() => setActiveMenu("list")}
                    >
                      List Buku
                    </button>
                  </li>
                </ul>
              </div>
            </nav>

            {content}
          </div>
        );
      }

      ReactDOM.createRoot(document.getElementById("root")).render(<App />);
    </script>
</body>

</html>