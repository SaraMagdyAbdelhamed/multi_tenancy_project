let questionCount = 1;

// Add question
document.querySelector('.add-question').addEventListener('click', function () {
    const questionsContainer = document.getElementById('questions-container');
    const question = document.createElement('div');
    question.classList.add('mb-8', 'question');

    const questionTitle = document.createElement('h3');
    questionTitle.textContent = 'Question ' + questionCount;

    const questionInput = document.createElement('input');
    questionInput.type = 'text';
    questionInput.name = 'questions[' + (questionCount - 1) + '][title]';
    questionInput.placeholder = 'Enter question';
    questionInput.classList.add('border', 'border-gray-300', 'p-2', 'rounded', 'w-full');

    const questionDescriptionInput = document.createElement('input');
    questionDescriptionInput.type = 'text';
    questionDescriptionInput.name = 'questions[' + (questionCount - 1) + '][description]';
    questionDescriptionInput.placeholder = 'Enter question description';
    questionDescriptionInput.classList.add('border', 'border-gray-300', 'p-2', 'rounded', 'w-full');

    const answersContainer = document.createElement('div');
    answersContainer.classList.add('mt-4', 'answers-container');

    const addAnswerButton = document.createElement('button');
    addAnswerButton.type = 'button';
    addAnswerButton.classList.add('add-answer', 'mt-2', 'bg-gray-300', 'hover:bg-gray-400', 'text-gray-700', 'font-semibold', 'py-2', 'px-4', 'rounded');
    addAnswerButton.textContent = 'Add Answer';

    question.appendChild(questionTitle);
    question.appendChild(questionInput);
    question.appendChild(questionDescriptionInput);
    question.appendChild(answersContainer);
    question.appendChild(addAnswerButton);

    questionsContainer.appendChild(question);

    questionCount++;
});

//add answer
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('add-answer')) {
        const answersContainer = event.target.parentNode.querySelector('.answers-container');
        if (answersContainer) {
            const answerCount = answersContainer.children.length;

            const answer = document.createElement('div');
            answer.classList.add('answer', 'flex', 'items-center');

            const answerInput = document.createElement('input');
            answerInput.type = 'text';
            answerInput.name = 'questions[' + (questionCount - 2) + '][choices][' + answerCount + '][title]';
            answerInput.placeholder = 'Enter answer';
            answerInput.classList.add('border', 'border-gray-300', 'p-2', 'rounded');

            const answerCheckbox = document.createElement('input');
            answerCheckbox.type = 'hidden'; // Use a hidden field to send the value
            answerCheckbox.name = 'questions[' + (questionCount - 2) + '][choices][' + answerCount + '][is_correct]';
            answerCheckbox.value = 'false';
            
            const answerCheckboxInput = document.createElement('input');
            answerCheckboxInput.type = 'checkbox';
            answerCheckboxInput.name = 'questions[' + (questionCount - 2) + '][choices][' + answerCount + '][is_correct]';
            answerCheckboxInput.value = 'false';
            answerCheckboxInput.classList.add('ml-2');
            answerCheckboxInput.addEventListener('change', function () {
                if (this.checked) {
                    answerCheckbox.value = 'true';
                } else {
                    answerCheckbox.value = 'false';
                }
            });

            const answerCheckboxLabel = document.createElement('label');
            answerCheckboxLabel.textContent = 'Correct Answer';
            answerCheckboxLabel.setAttribute('for', 'correct_answer[' + questionCount + ']');
            answerCheckboxLabel.classList.add('ml-2');

            const answerOrderInput = document.createElement('input');
            answerOrderInput.type = 'number';
            answerOrderInput.name = 'questions[' + (questionCount - 2) + '][choices][' + answerCount + '][order]';
            answerOrderInput.placeholder = 'Enter answer order';
            answerOrderInput.classList.add('border', 'border-gray-300', 'p-2', 'rounded');

            const answerDescriptionInput = document.createElement('input');
            answerDescriptionInput.type = 'text';
            answerDescriptionInput.name = 'questions[' + (questionCount - 2) + '][choices][' + answerCount + '][description]';
            answerDescriptionInput.placeholder = 'Enter answer description';
            answerDescriptionInput.classList.add('border', 'border-gray-300', 'p-2', 'rounded');

            const answerExplanationInput = document.createElement('input');
            answerExplanationInput.type = 'text';
            answerExplanationInput.name = 'questions[' + (questionCount - 2) + '][choices][' + answerCount + '][explanation]';
            answerExplanationInput.placeholder = 'Enter answer explanation';
            answerExplanationInput.classList.add('border', 'border-gray-300', 'p-2', 'rounded');

            const removeAnswerButton = document.createElement('button');
            removeAnswerButton.type = 'button';
            removeAnswerButton.classList.add('remove-answer', 'ml-2', 'text-red-500', 'font-semibold');
            removeAnswerButton.textContent = 'Remove';

            answer.appendChild(answerInput);
            answer.appendChild(answerCheckbox);
            answer.appendChild(answerCheckboxInput);
            answer.appendChild(answerCheckboxLabel);
            answer.appendChild(answerOrderInput);
            answer.appendChild(answerDescriptionInput);
            answer.appendChild(answerExplanationInput);
            answer.appendChild(removeAnswerButton);

            answersContainer.appendChild(answer);
        }
    }
});

// Remove answer
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-answer')) {
        const answerContainer = event.target.parentNode;
        const answersContainer = answerContainer.parentNode;

        answersContainer.removeChild(answerContainer);
    }
});


// Get the start and end time input elements
const startTimeInput = document.getElementById('start_time');
const endTimeInput = document.getElementById('end_time');

// Validate the form before submission
document.querySelector('form').addEventListener('submit', function(event) {
  if (startTimeInput.value && endTimeInput.value) {
    const startTime = new Date(startTimeInput.value);
    const endTime = new Date(endTimeInput.value);

    if (endTime <= startTime) {
      event.preventDefault(); // Prevent form submission
      alert('End time must be after start time');
    }
  }
});