<?php 
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Services\QuizService; 
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Repositories\QuizRepository;
use App\Http\Requests\CreateQuizRequest;

test('Admin Can show All quizzes', function () {

    $user = User::factory()->create();

    $response = $this
        ->actingAs($user,'web');

    $quizzes = Quiz::factory()
    ->count(5) // Change the count value as per your requirement
    ->create();

    foreach ($quizzes as $quiz) {
        $questions = Question::factory()
            ->count(5)
            ->create(['quiz_id' => $quiz->id]);

        foreach ($questions as $question) {
            $choices = Choice::factory()
                ->count(4)
                ->create(['question_id' => $question->id]);

            // Set one choice as correct and update the order
            $correctChoice = $choices->random();
            $correctChoice->update(['is_correct' => true]);

            $choices = $choices->sortBy('id');
            $choices->each(function ($choice, $index) {
                $choice->update(['order' => $index + 1]);
            });
        }
    }

    // Create the QuizService mock
    $quizServiceMock = Mockery::mock(QuizService::class);

    // Set up the expectation for the getAllQuizzes() method
    $quizServiceMock->shouldReceive('getAllQuizzes')->once()->andReturn($quizzes);

    // Call the code that should invoke the getAllQuizzes() method on the QuizService
    $quizServiceMock->getAllQuizzes(); 

    // Assert the expected behavior
    $quizServiceMock->shouldHaveReceived('getAllQuizzes')->once();

    $response = $this->get(route('quizes'));

    $response->assertStatus(200)
    ->assertViewIs('tenant.quizes.index')
    ->assertViewHas('quizzes');
});


test('Admin can store quiz', function () {
    try{   
        $user = User::factory()->create();

         $this->actingAs($user,'web');
        // Set up the necessary request data
        $requestData = [
            'title' => 'Quiz Title',
            'description' => 'Quiz Description',
            'mark' => 10,
            'start_time' => '2024-07-01 09:00:00',
            'end_time' => '2024-07-01 10:00:00',
            'questions' => [
                [
                    'title' => 'Question 1',
                    'description' => 'Question 1 Description',
                    'mark' => 10,
                    'choices' => [
                        [
                            'title' => 'Choice 1',
                            'is_correct' => true,
                            'order' => 1,
                            'description' => 'Choice 1 Description',
                            'explanation' => 'Choice 1 Explanation',
                        ],
                        [
                            'title' => 'Choice 2',
                            'is_correct' => false,
                            'order' => 2,
                            'description' => 'Choice 2 Description',
                            'explanation' => 'Choice 2 Explanation',
                        ],
                    ],
                ],
            ],
        ];

        $CreateQuizRequest = Mockery::mock(CreateQuizRequest::class);
        // Mock the validated method of the CreateQuizRequest
        $CreateQuizRequest->shouldReceive('validated')->andReturn($requestData);
        
        // Call the store method using the POST helper function
        $response = $this->post(route('quizes.store'), $requestData);

        // Assert that the response redirects to the quizes route with a success message
        $response->assertRedirect(route('quizes'))
                ->assertSessionHas('success', 'Quiz created successfully');
        
        
        } catch (\Exception $e) {
            // Log the error
            Log::error($e->getMessage());
            
            // Re-throw the exception to fail the test
            throw $e;
        }
});