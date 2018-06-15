[1mdiff --git a/app/Exceptions/Handler.php b/app/Exceptions/Handler.php[m
[1mindex 7e2563a..af2d3ac 100644[m
[1m--- a/app/Exceptions/Handler.php[m
[1m+++ b/app/Exceptions/Handler.php[m
[36m@@ -2,6 +2,7 @@[m
 [m
 namespace App\Exceptions;[m
 [m
[32m+[m[32muse App\Mail\ErrorReport;[m
 use Exception;[m
 use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;[m
 [m
[36m@@ -36,7 +37,8 @@[m [mclass Handler extends ExceptionHandler[m
      */[m
     public function report(Exception $exception)[m
     {[m
[31m-        parent::report($exception);[m
[32m+[m[32m        \Mail::to('admin@example.com')->send(new ErrorReport($exception));[m
[32m+[m[32m        return parent::report($exception);[m
     }[m
 [m
     /**[m
[1mdiff --git a/app/Http/Controllers/HomeController.php b/app/Http/Controllers/HomeController.php[m
[1mindex 8706315..053ec3e 100644[m
[1m--- a/app/Http/Controllers/HomeController.php[m
[1m+++ b/app/Http/Controllers/HomeController.php[m
[36m@@ -2,6 +2,7 @@[m
 [m
 namespace App\Http\Controllers;[m
 [m
[32m+[m[32muse App\Mail\ErrorReport;[m
 use Google_Client;[m
 use Google_Service_Directory;[m
 use Illuminate\Http\Request;[m
[1mdiff --git a/app/Http/Controllers/KnowledgeCafe/KnowledgeCafeController.php b/app/Http/Controllers/KnowledgeCafe/KnowledgeCafeController.php[m
[1mindex eb9b686..66cf57a 100644[m
[1m--- a/app/Http/Controllers/KnowledgeCafe/KnowledgeCafeController.php[m
[1m+++ b/app/Http/Controllers/KnowledgeCafe/KnowledgeCafeController.php[m
[36m@@ -17,4 +17,4 @@[m [mclass KnowledgeCafeController extends Controller[m
        return view('knowledgecafe.index');[m
     }[m
 [m
[31m-}[m
[32m+[m[32m}[m
\ No newline at end of file[m
[1mdiff --git a/database/migrations/2018_03_13_132221_create_users_table.php b/database/migrations/2018_03_13_132221_create_users_table.php[m
[1mindex ff62bb0..4812ee7 100644[m
[1m--- a/database/migrations/2018_03_13_132221_create_users_table.php[m
[1m+++ b/database/migrations/2018_03_13_132221_create_users_table.php[m
[36m@@ -34,4 +34,4 @@[m [mclass CreateUsersTable extends Migration[m
     {[m
         Schema::dropIfExists('users');[m
     }[m
[31m-}[m
[32m+[m[32m}[m
\ No newline at end of file[m
