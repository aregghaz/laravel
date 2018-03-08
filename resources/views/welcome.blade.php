<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav col-md-12">
        <li class="col-md-2 menu"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li class="col-md-2 menu"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li class="col-md-2 menu"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li class="col-md-2 menu"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li class="col-md-2 menu"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li class="col-md-2 menu"><a href="#">Link <span class="sr-only">(current)</span></a></li>

    </ul>
</nav>
<div class="vertical-scroll-wrapper" id='relative'>
    <img class='body_img' src="/themes/responsiv-flat/assets/images/task1/VictorChurchill_DCurci_03.jpg" alt="">
    <div class='row '>
        <div class='col-md-7 body_middle' style='z-index:1'>
            <h1 class='body_text'>test</h1>
            <p class='body_text'>asdasdsadsadsadsadsa</p>
        </div>
        <div class='col-md-5 body_middle'><img class='body_img'
                                               src="/themes/responsiv-flat/assets/images/task1/VictorChurchill_DCurci_03.jpg"
                                               alt=""></div>
    </div>
</div>
    <div class=" horizontal-scroll-wrapper squares ">
        {% set temp_date = '' %}


        {% set this_date = entry.date|date("Y-m-d") %}
        {% if this_date != temp_date %}
        {% set temp_date = this_date %}
        <center><h3>{{ entry.date|date('F jS, Y') }}</h3></center>

        {% endif %}
        {% for entry in entries %}
        {# Comment:
        Matching dates in records for sorting in view
        #}
        {% set this_date = entry.date|date("Y-m-d") %}

        {# Comment:
        This groups dates and puts relevant records under date
        #}


        {# Comment:
        Timeline Entry - Time & Title
        #}
        <div class='col-md-3'>
            <p class="lead ">
                <small><strong>{{ entry.time|date('H:i') }}</strong></small> {{ entry.title }}<br/>
            </p>
            {# Comment:
            Timeline Entry - Text
            #}
            <p>
                {{ entry.text|raw }}
            </p>
        </div>
        {# Comment:
        Puts HR for each entry except last
        #}
        {% if not loop.last %} {% endif %}
        {% endfor %}

    </div>


<div class='row'>
    <img class='' style='width: 100%' src="/themes/responsiv-flat/assets/images/task1/leeuwen-design.png" alt="">
</div>
<div id="background" class="row">
    <div class="col-md-6">
        <div class="col-md-6 col-md-offset-6">
            <br>
            <h2 style='color:#fff; text-align: right;'>Service</h2>
            <p style='color:#fff; text-align: right;'>Sinds 1958 uw ambachtelijke topslagerij.</p>
            <p style='color:#fff; text-align: right;'>Kom gerust eens langs in onze winkel in</p>
            <p style='color:#fff; text-align: right;'> Lunteren en wij helpen u graag verder!</p>
            <br>
            <p style='color:#fff; text-align: right;'>Of als u een vraag ons heeft, neem contact met one op</p>

        </div>
    </div>
    <div class="col-md-6">
    </div>
    <div class="col-md-12">
        <p style='color:#fff; text-align: center;'> Copyright Slagerij Ab van Leeuwen</p>
        <p style='color:#fff; text-align: center;'>Website by Novisit</p>
    </div>


</div>