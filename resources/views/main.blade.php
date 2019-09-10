<!DOCTYPE html>
<html>
    <head>
        <title>W3.CSS Template</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <style>body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}</style>
    </head>
    <body class="w3-light-grey">
        <div class="w3-content" style="max-width:1800px">
            <header class="w3-container w3-center w3-padding-32"> 
                <h1><b>Anıl Şenocak</b></h1>
                <p>@yield('kategoriler')</p>
            </header>
            <div class="w3-row">
                <div class="w3-col l8 s12">
                    @yield('body')
                </div>
                <div class="w3-col l4">
                    <div class="w3-card w3-margin w3-margin-top">
                        <img src="https://www.w3schools.com/w3images/avatar_g.jpg" style="width:100%">
                            <div class="w3-container w3-white">
                            <h4><b>My Name</b></h4>
                        <p>Just me, myself and I, exploring the universe of uknownment. I have a heart of love and a interest of lorem ipsum and mauris neque quam blog. I want to share my world with you.</p>
                        </div>
                    </div>
                    <hr>
                    <!-- Posts -->
                    <div class="w3-card w3-margin">
                        <div class="w3-container w3-padding">
                            <h4>Popular Posts</h4>
                        </div>
                        <ul class="w3-ul w3-hoverable w3-white">
                            <li class="w3-padding-16">
                                <img src="https://www.w3schools.com/w3images/workshop.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                                <span class="w3-large">Lorem</span><br>
                                <span>Sed mattis nunc</span>
                            </li>
                            <li class="w3-padding-16">
                                <img src="https://www.w3schools.com/w3images/gondol.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                                <span class="w3-large">Ipsum</span><br>
                                <span>Praes tinci sed</span>
                            </li> 
                            <li class="w3-padding-16">
                                <img src="https://www.w3schools.com/w3images/skies.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                                <span class="w3-large">Dorum</span><br>
                                <span>Ultricies congue</span>
                            </li>   
                            <li class="w3-padding-16 w3-hide-medium w3-hide-small">
                                <img src="https://www.w3schools.com/w3images/rock.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                                <span class="w3-large">Mingsum</span><br>
                                <span>Lorem ipsum dipsum</span>
                            </li>  
                        </ul>
                    </div>
                    <hr> 
                    <div class="w3-card w3-margin">
                        <div class="w3-container w3-padding"><h4>Tags</h4></div>
                        <div class="w3-container w3-white">
                            <p><span class="w3-tag w3-black w3-margin-bottom">Travel</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">New York</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">London</span>
                            <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">IKEA</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">NORWAY</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">DIY</span>
                            <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Ideas</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Baby</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Family</span>
                            <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">News</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Clothing</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Shopping</span>
                            <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Sports</span> <span class="w3-tag w3-light-grey w3-small w3-margin-bottom">Games</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
            <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button>
            <button class="w3-button w3-black w3-padding-large w3-margin-bottom">Next »</button>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </footer>
    </body>
</html>
