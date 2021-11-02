JavaScript Naming Conventions

JavaScript is used by many thousands of developers every day to create all kinds of websites and applications. But fortunately, there are some very commonly used naming conventions that are followed by ColoredCow Portal. When naming their uses JavaScript project's variables, class and functions to work with git repositories.

Naming Class in JavaScript

Adding ID to a pre-existing HTML element
First, you need to find the element. 

class_name should be in lower case, with underscores to separate words (snake_case), and should be in plural form.

This can be done using:		
document.getElementsByClass("class_name");

For example: posts, project_tasks, uploaded_images, software_developer.
Bad examples: all_posts, Posts, post, blogPosts, softwareDeveloper
	     	  document.getElementsByClass("software_developer");


Naming idName in JavaScript

Adding ID to a pre-existing HTML element
First, you need to find the element. 

Normal idName should typically be in camelCase, with the first character lower case.

This can be done using:		

document.getElementById("idName");

For example: posts, project_tasks, uploaded_images.
Bad examples: all_posts, Posts, post, blogPosts, softwareDeveloper
	          document.getElementsByClass("softwareDeveloper");


Naming Conventions for PHP

PHP is used by many thousands of developers every day to create all kinds of websites and applications. But fortunately, there are some very commonly used naming conventions that are followed by many developers when naming their PHP project's variables, class and functions. Here is my overview of the best naming conventions for PHP. PHP is a general-purpose scripting language geared towards web development. The PHP reference implementation is now produced by The PHP Group.

Variables

A variable is what stores data. A data can be of any type, be it String, Integer, Floating point values or Boolean, Arrays. I’d even go further to say that we should follow same conventions when defining Array Keys and Database Field Names as well. It improves consistency across our whole development stack.

Methods in your variable in PHP projects, like variables in your PHP projects, should be camelCase but the first character lower case.

For example:   $myVar;
	       $myName= "John";

Bad examples:  $my_name;
	       $my_var = "Doe";


Functions

A function is a piece of code which does a specific task. Each programming language consists of a lot of functions which do different tasks.

Methods in your variable in PHP projects, like all functions in your PHP projects, should be camelCase but the first character lower case.

This can be done using:	  function functionName(){
			  					// Do something
			 			  }

For example:  getName(), connectToDatabase(), prepareOutput().
Bad examples: databaseConnection(), Getname(), prepare_Output().


Classes

A PHP class, and more generally, provides additional approaches to reusability, and can be used for a variety of purposes: They can describe entities that have known properties and behaviors. They can be used as messages to functions and other objects.

Methods in your classes in PHP projects, like classes in your PHP projects, should be Tilte Case.

This can be done using:	  class Model User{
							// Do something
			 			  }

For example: Model User, Get Name, Prepare Output.



Naming Conventions for Blade Template

The Blade is a powerful templating engine in a Laravel framework. The blade allows to use the templating engine easily, and it makes the syntax writing very simple. The blade templating engine provides its own structure such as conditional statements and loops. To create a blade template, you just need to create a view file and save it with a .blade.php extension instead of .php extension. The blade templates are stored in the /resources/view directory. The main advantage of using the blade template is that we can create the master template, which can be extended by other files.


Variables

Normal variables should typically be in camelCase, with the first character lower case.

This can be done using:	{{$variableName}};	

For example: $users, $bannedUsers, $softwareDeveloper.
Bad examples: $all_banned_users = ..., $Users=....


Classes

class definitions begin with the keyword class, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.

class_name should be in lower case, with underscores to separate words (snake_case), and should be in plural form.

For example:
{!! Form::file('motivation', old('motivation'), ['class' => 'custom_file_input']) !!}

As you can see I set an class by doing 'class' => 'custom_file_input'. However when I go to the page where this blade is rendered it outputs this:

<input name="motivation" type="file">
 
Bad example:
{!! Form::file('motivation', old('motivation'), ['class' => 'custom-file-input']) !!}     


Naming idName in Blade Template

For example:
{!! Form::file('motivation', old('motivation'), ['id' => 'inputGroupMotivation']) !!}

As you can see I set an id by doing 'id' => 'inputGroupMotivation'. However when I go to the page where this blade is rendered it outputs this:

<input name="motivation" type="file">

Bad example:
{!! Form::file('motivation', old('motivation'), ['id' => 'input_Group_Motivation']) !!}










 




 


