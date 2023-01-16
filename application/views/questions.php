
    <div class="content" id="content">
    
    </div>

    <script type="text/template" id="questions-template">
        <div class="questionHeader">
            <div class="title"><h2>All Questions</h2></div>
            <div class="askQuestion" id="askQuestion"><a href="#/askquestion">Ask Questions</a></div>
        </div>
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
                    <form>
                        <span>Body:</span>
                        <textarea name="" id="" cols="30" rows="10" name="body" id="body"></textarea>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </script>

    <script type="text/template" id='ask-question'>
       <div class="contentBx">
        <div class="formBx">
            <h2>Ask Question</h2>
            <form>
                <div class="inputBx">
                    <span>Title</span>
                    <input type="text" name="title" id="title" required>
                </div>
                <div class="inputBx">
                    <span>Body</span>
                    <textarea name="body" id="body" required></textarea>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
       </div>
    </script>

    <script src="<?php echo base_url(); ?>assets/js/questions.js"></script>
