<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moves</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            display: flex;
            flex-direction: column;
            height: 500px;
            width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f6f6;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-group label {
            width: 100px;
            font-weight: 500;
        }
        .form-group input {
            flex: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #9d9c9c;
            background-color: #2f312e; /* Matching colors */
            color: white;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 15px;
            background: rgba(97, 120, 93, 0.808);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            flex: 1;
            margin: 0 5px;
        }
        .btn:hover {
            opacity: 0.82;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Moves</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" id="user_id" name="user_id" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" required>
            </div>
            <div class="form-group">
                <label for="location_id">Location ID:</label>
                <input type="text" id="location_id" name="location_id" required>
            </div>
            
            <div class="button-container">
                <button type="submit" name="action" value="add" class="btn">Add</button>
                <button type="submit" name="action" value="search" class="btn">Search</button>
                <button type="submit" name="action" value="modify" class="btn">Modify</button>
                <button type="submit" name="action" value="delete" class="btn">Delete</button>
            </div>
        </form>
    </div>
</body>
</html>
