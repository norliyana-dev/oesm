<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- EXAM INFO + TIMER --}}
                <div class="flex justify-between items-center mb-6 border-b pb-4">

                    <div>
                        <p><strong>Subject:</strong> {{ $exam->subject->name ?? '-' }}</p>
                        <p><strong>Duration:</strong> {{ $exam->duration }} minutes</p>
                    </div>

                    {{-- TIMER --}}
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Time Remaining</p>
                        <p id="timer" class="text-2xl font-bold text-red-600">Loading...</p>
                    </div>

                </div>

                {{-- QUESTIONS FORM --}}
                <form id="examForm" action="{{ route('student.exam.submit', $exam->id) }}" method="POST">
                    @csrf

                    @foreach ($exam->questions as $index => $question)

                        <div class="mb-6 border-b pb-4">

                            <p class="font-semibold mb-3">
                                Q{{ $index + 1 }}. {{ $question->question_text }}
                            </p>

                            {{-- MCQ --}}
                            @if ($question->type === 'mcq')
                                @foreach ($question->options as $option)
                                    <label class="block mb-2">
                                        <input type="radio"
                                               name="answers[{{ $question->id }}]"
                                               value="{{ $option->option_text }}"
                                               class="mr-2">
                                        {{ $option->option_text }}
                                    </label>
                                @endforeach
                            @endif

                            {{-- OPEN TEXT --}}
                            @if ($question->type === 'open')
                                <textarea
                                    name="answers[{{ $question->id }}]"
                                    class="w-full border-gray-300 rounded-lg focus:ring focus:ring-blue-200"
                                    rows="3"
                                    placeholder="Type your answer here..."
                                ></textarea>
                            @endif

                        </div>

                    @endforeach

                    {{-- SUBMIT BUTTON --}}
                    <div class="flex justify-end mt-6">
                        <button type="button" id="submitBtn" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            Submit Answer
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let timerDisplay = document.getElementById('timer');
    let form = document.getElementById('examForm');
    let submitBtn = document.getElementById('submitBtn');

    if (!timerDisplay || !form) return;

    let endTime = {{ $submission->submitted_at->timestamp }} * 1000;

    function updateTimer() {

        let now = Date.now();
        let distance = Math.floor((endTime - now) / 1000);

        if (distance <= 0) {

            clearInterval(timerInterval);
            timerDisplay.textContent = "00:00";

            Swal.fire({
                title: 'Time is up!',
                text: 'Your exam will be submitted automatically.',
                icon: 'warning',
                allowOutsideClick: false
            }).then(() => {
                form.submit();
            });

            return;
        }

        let minutes = Math.floor(distance / 60);
        let seconds = distance % 60;

        timerDisplay.textContent =
            minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }

    updateTimer();
    let timerInterval = setInterval(updateTimer, 1000);

    submitBtn.addEventListener('click', function () {

        Swal.fire({
            title: 'Submit Exam?',
            text: "Once submitted, you cannot change your answers.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});
</script>