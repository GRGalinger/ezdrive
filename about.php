<?php 
	include_once 'header.php'; 
?>

<div class="container-about">
    <h1> What is EZ-Drive? </h1>
    <p> EZ-Drive is a web application designed to help you easily upload files to your favorite cloud services all from one
        convenient place.
        We currently offer connection to Google Drive, Dropbox, and OneDrive services.
        This application was designed by Grant Galinger, Josh Phillips, and Kyle Spraggins for our senior design project. 
        If you wish to learn more, please visit our 
        <a href="https://github.com/GRGalinger/SeniorDesign" target="_blank">Github repository</a>.
    </p>
    <h1> How does it work? </h1>
    <p> EZ-Drive works by utilizing the public API libraries for each of the cloud services. 
        These APIs allow us to form a connection between this application and your specific cloud service account. 
        The connection is based around the principles of OAuth 2.0 Authorization. 
        Once the user has selected the files they wish to upload through our easy to use drag and drop interface, 
        they are securely backed up to your preferred cloud service.
        For the full User Documentation, view our <a href="https://github.com/GRGalinger/SeniorDesign/blob/master/Files/Assignments/User_Documentation.md" target="_blank">User Documentation</a> 
        inside our repository.
    </p>
    <h1> How do I use it? </h1>
    <p> Easy! To get started, sign in to your EZ-Drive account, or, click the sign up button to create one.
        Then, sign in to your account with whichever available cloud services you choose.
        This will allow us to backup your files for you.
        If you don't have an account with Google Drive, DropBox, or OneDrive, you will need to create one. 
        Once you have selected the cloud services you want to use, simply drag and drop the files
        you would like to backup into the provided field.
        When the upload(s) have finished, the results will be displayed including your successfully uploaded files.
    </p>
    <h1> What technologies did you use? </h1>
    <p> EZ-Drive uses a handful of technologies to get its job done, including PHP, JavaScript, and MySQL.
        PHP is a powerful scripting language for web development, with many uses including managing content and
        connecting with databases.
        JavaScript is also essential to any functional website and powers many of EZ-Drive's capabilities, including
        our easy-to-use drag-and-drop file upload system.
        MySQL is an extremely popular database solution for storing any data a web-application may need.
        Testing for EZ-Drive is done using WAMP server.
    </p>
    <h1> How did you choose the design? </h1>
    <p> Even in the very beginning of this project, we wanted EZ-Drive to be as easy and convenient as possible to use. 
        With our sleek and minimalist design, users can enjoy the features of EZ-Drive
        without any unwanted distractions or delays.
        That way, our users can quickly and easily backup their files to their favorite cloud services with no hassle.
    </p>

</div>










<?php 
    include_once 'footer.php';
?>