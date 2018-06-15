<!DOCTYPE html>
<html>
<head>
	<title>Error Report</title>
</head>
<body>
	there was an exception <br>
	Exception message: {{ $exception->getMessage() }} 
	<br>
	Exception code: {{ $exception->getCode() }}
</body>
</html>