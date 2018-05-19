{% extends 'layouts/main.volt' %}

{% block content %}

  <div class="__page__top">
    <h1>Frequently Asked</h1>
    <h2>Write us an email to hi@spreadshare.co if your question wasn’t answered. We get back to you asap.</h2>
  </div>

  <div class="__page__container">

  <div class="__page__wrapper">

    <div id="product">
    <h3>I found a bug, what should I do?</h3>
    <p>Write us an email to hi@spreadshare.co</p>
    </br>

    <h3>What is your Tech Stack?</h3>
    <p>In our back-end we used PHP7 and Phalcon framework. For our databases we used MySQL and for the search Elasticsearch. We built our front-end with ReactJS and the smart contract for the token distribution using the Ethereum platform.</p>
    <p>For creating the tables we used the community edition of Handsontables — a JavaScript/HTML5 Spreadsheet Component for Web Apps — which is available on Git. </p>

    </br>
    <h3>What are tags?</h3>
    <p>Tags are a way to categorize your content, so that others can find it. The more relevant the tags are to the post, the more like-minded people will come across it.</p>

    </br>
    <h3>Does it cost anything to post, comment, or vote?</h3>
    <p>No. It is free to contribute on SpreadShare.co. You might even get paid for it!</p>
    </br>

    <h3>Can I earn money on SpreadShare?</h3>
    <p>Yes, by contributing to our community.</p>
    </br>

    <h3>Can I sell data on SpreadShare?</h3>
    <p>Yes, in the near future we allow users to create private tables which users wanting to access have to pay for. Downloading tables, getting access to a table’s API and requesting table data will be other features a user can use the tokens for.</p>
    </br>

    <h3>Why did we decide to replace Google sheets with our own table solution?</h3>
    <ul>
     <li>Sheets don’t allow you to build an audience, can’t be followed or subscribed</li>
     <li>Sheets don’t provide page and user stats</li>
     <li>User roles in sheets are designed for organisations, not communities.</li>
     <li>Sheets can’t be monetised.</li>
     <li>Sheets don’t foster real collaboration</li>
     <li>Sheets don’t acknowledge the creators</li>
     <li>Sheets can’t be searched or discovered.</li>
     <li>Sheets can’t be rated or reviewed.</li>
     <li>Sheets don’t like to be searched / indexed.</li>
     <li>Sheets are not linking to, interacting with each other. Every sheet behaves like an own platform, there are no intersections, connections to other sheets.</li>
     <li>Sheets don’t offer a clean visual experience </li>
    </ul>

    </div>

    <h3>How can I create a table</h3>
    <p>You have to be logged in to create a table. There should be a button “Create Table” in your header (right side).</p>
    </br>

    <h3>What are locations</h3>
    <p>Tables can be set to specific locations. Tables are a great way to collect local information like venues, places, people or meetup’s in a city. Filtering by location let’s you explore local content.</p>
    </br>


    <h3>How do I change content of a cell</h3>
    <p>Right-click on your mouse and click “Edit Cell” (or) Just click on the cell and add your content.</p>
    </br>


    <h3>How do I become an admin</h3>
    <p>We’ll soon release a Team feature which allows an admin to assign other admins to a table.</p>
    </br>


    <h3>Can I delete a table</h3>
    <p>Yes, you can delete a table if you are the creator. If you are not but find a table which seems to be spam or other undesired content, please flag the table. Our community support will review the table and remove it if reasonable.</p>
    </br>


    <h3>How do I delete a table?</h3>
    <p>If you are the admin of the table go to table settings and click “Delete table”.</p>
    </br>

    <h3>Can I delete content I have added to a table</h3>
    <p>Yes, use the right-click menu.</p>
    </br>



  </div>

  <div class="__page__sidebar">
   <ul>
    <li><a href="/faq">Company</a></li>
    <li class="active"><a href="/faq/product">Product</a></li>
    <li><a href="/faq/content">Content</a></li>
    <li><a href="/faq/token">Token</a></li>
   </ul>
  </div>
  </div>

{% endblock %}
