<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container" style="top:40px; position:relative;">
<div class="panel panel-primary">
      <div class="panel-heading">
            <h3 class="panel-title">create task</h3>
      </div>
      <div class="panel-body">
            <form>
            <div class="form-group">
            <label for="my-textarea">category</label>
                <select name="select" id="input" class="form-control" required>
                    <option value="1" disabled >select category</option>
                    <option value="2">agricultural</option>
                    <option value="3">geographical</option>
                    <option value="3">outphishing</option>
                    <option value="3">travel agency</option>
                    <option value="3">kingsship</option>
                </select>
                </div>  
            <div class="form-group">
            <label for="my-textarea">select employees</label>
                <select name="select" id="input" class="form-control" required>
                    <option value="1" disabled>select employees</option>
                    <option value="2">kenedy okings</option>
                    <option value="3">jeremy stevins</option>
                </select>
            </div>
            <div class="form-group">
            <label for="my-textarea">task</label>
                <input type="text" class="form-control" placeholder="task" >
            </div> 
                <div class="form-group">
                    <label for="my-textarea">Description</label>
                    <textarea id="my-textarea" class="form-control" name="" rows="3" placeholder="description"></textarea>
                </div>
                
                <a class="btn btn-large btn-block btn-primary" href="#" role="button">submit</a>
                
            </form>
      </div>
</div>
</div>
<footer style="padding:2em; background:black; text-align:center; margin-top:16em; color:white;">made with love by @the chick </footer>

<script src="bootstrap-3.3.7/js/jquery.js"></script>
    <script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
