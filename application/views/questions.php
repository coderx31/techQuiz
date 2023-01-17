
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
                    <!-- to be removed -->
                    <!-- <a href="#"><i class="fa-solid fa-caret-up" class="upvote" id="upvote"></i></a> -->
                    <p> <%= question.votes %></p>
                    <!-- <a href="#"><i class="fa-solid fa-caret-down" class="downvote" id="downvote"></i></a> -->
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
                    <p href=""><i class="fa-solid fa-caret-up" class="upvote" id="upvote"></i></p>
                    <p><%= question.questions.votes %></p>
                    <p href=""><i class="fa-solid fa-caret-down" class="downvote" id="downvote"></i></p>
                </div>
                <div class="title">
                    <h2><%= question.questions.title %></p>
                    <small>CreatedAt:<%= question.questions.createdAt %></small>
                    <small>Updated : <%= question.questions.updated == 0 ? false : true %></small>
                </div>
            </div>
            <div class="questionBody">
                <p><%= question.questions.body %></p>
            </div>
             <!-- only question owner allowed to edit and delete the question -->
            <% if (localStorage.getItem('user_id') === question.questions.user_id) { %>
                <div class="actionBtns" id="actionBtns">
                    <a href=#/editquestion/<%= question.questions.question_id %> class="edit">Edit</a>
                    <button class="delete" id="deleteQuestion">Delete</button>
                </div>
            <% } %>
            <div class="answerBox">
                <h3 class="title">Answers</h3>
                <% _.each(question.answers, function(answer) { %>
                    <div class="answers">
                        <div class="votes">
                            <p href=""><i class="fa-solid fa-caret-up" class="answerupvote" id="answerUpvote"></i></p>
                            <p><%= answer.votes %></p>
                            <p href=""><i class="fa-solid fa-caret-down" class="answerdownvote" id="answerDownvote"></i></p>
                        </div>
                        <div class="description">
                            <p><%= answer.body %></p>
                            <small>Updated : <%= answer.updated == 0 ? false : true %></small>
                            <% if (localStorage.getItem('user_id') === answer.user_id) { %>
                            <div class="actionBtns">
                                <!-- <a href=#/editquestion/<%= question.questions.question_id %> class="edit">Edit</button> -->
                                <button class="delete" id="deleteAnswer">Delete</button>
                            </div>
                            <% } %>
                        </div>
                    </div>
                <% }) %>
                <div class="addAnswer">
                    <!-- <form>
                        <input type="hidden" name="question_id" id="question_id" value="<%= question.questions.question_id %>">
                        <span>Body:</span>
                        <textarea name="answer_body" id="answer_body"></textarea>
                        <input type="submit" value="Submit">
                    </form> -->
                    <div class="formBx">
                        <h2>Add Answer</h2>
                        <form>
                            <input type="hidden" name="question_id" id="question_id" value="<%= question.questions.question_id %>">
                            <div class="inputBx">
                                <span>Body</span>
                                <textarea name="answer_body" id="answer_body" required></textarea>
                            </div>
                            <div class="inputBx">
                                <input type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                    
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

    <script type="text/template" id="edit-question">
    <div class="contentBx">
        <div class="formBx">
            <h2>Edit Question</h2>
            <form>
                <div class="inputBx">
                    <span>Title</span>
                    <input type="text" name="title" id="title" value = "<%= question.questions.title %>" required>
                </div>
                <div class="inputBx">
                    <span>Body</span>
                    <textarea name="body" id="body" required><%= question.questions.body %></textarea>
                </div>
                <div class="inputBx">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
       </div>
    </script>

    <script src="<?php echo base_url(); ?>assets/js/questions.js"></script>
