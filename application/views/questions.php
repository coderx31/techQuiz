
    <div class="content" id="content">
        <!-- <h1>Questions page rendering with the help of backbone and _</h1>
        <a href="#">Ask Question</a> -->
    </div>

    <!-- question template with backbone + _ -->
    <!-- <script type="text/template" id="questions-template">
        <div class="question">
            <div class="vote"></div>
            <div class="description">
                <% _.each(questions, function(question) { %>
                    <a href = #/question/<%= question.question_id %> > <%= question.title %></a>
                    <p> <%= question.votes %></p>
                <% }) %>
            </div>
        </div>
    </script> -->

    <script type="text/template" id="questions-template">
        <% _.each(questions, function(question) { %>
            <div class="question">
                <div class="vote">
                    <a href="#"><i class="fa-solid fa-caret-up"></i></a>
                    <p> <%= question.votes %></p>
                    <a href="#"><i class="fa-solid fa-caret-down"></i></a>
                </div>
                <div class="description">
                    <a href = #/question/<%= question.question_id %> > <%= question.title %></a>
                </div>
            </div>
        <% }) %>
    </script>


    <script type="text/template" id='question-template'>
        <!-- <h1>Question View</h1>
        <h2><%= question.questions.title %></h2>
        <p><%= question.questions.body %></p> -->

        <div class="questionBox">
            <div class="titleBox">
                <div class="vote">
                    <a href="#"><i class="fa-solid fa-caret-up"></i></a>
                    <p><%= question.questions.votes %></p>
                    <a href="#"><i class="fa-solid fa-caret-down"></i></a>
                </div>
                <div class="title">
                    <h2><%= question.questions.title %></p>
                    <small>CreatedAt:<%= question.questions.createdAt %></small>
                    <small>need to check conditional rendering for that</small>
                </div>
            </div>
            <div class="questionBody">
                <p><%= question.questions.body %></p>
            </div>
            <div class="answerBox">
                <% _.each(question.answers, function(answer) { %>
                    <div class="answers">
                        <p><%= answer.body %></p>
                        <small><%= answer.updated %></small>
                    </div>
                <% }) %>
                <div class="addAnswer">
                    <form action="" method="post">
                        <span>Body:</span>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id='ask-question'>
        <h1>Ask Question View</h1>
    </script>

    <script src="<?php echo base_url(); ?>assets/js/questions.js"></script>
