<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(\Illuminate\Support\Facades\Auth::user()->type != USER_TYPE_ADMIN)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="stats shadow">

                    <div class="stat">
                        <div class="stat-title">Total Students</div>
                        <div class="stat-value text-primary">{{ number_format($stats['students']) }}</div>
                        <div class="stat-desc">Total Students Registered</div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Total Rooms</div>
                        <div class="stat-value text-primary">{{ number_format($stats['rooms']) }}</div>
                        <div class="stat-desc">Total Rooms Created</div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Total Exams</div>
                        <div class="stat-value text-primary">{{ number_format($stats['exams']) }}</div>
                        <div class="stat-desc">Total Exams Created</div>
                    </div>

                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                    <div>
                        <canvas id="examTypesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                    <div>
                        <canvas id="groupsStudentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-5">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3>All Students</h3>
                    </div>
                    <table class="table table-compact w-full">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Enrolled in Groups</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->username }}</td>
                                <td>
                                    <div class="badge badge-accent font-bold text-gray">Student</div>
                                </td>
                                <td>
                                    <ul>@foreach($student->groups as $sgroup)
                                            <li>{{ $sgroup->name }}</li>
                                        @endforeach</ul>
                                </td>
                                <td>{{ $student->created_at->format('m/d/Y h:i a') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Students</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $students->links() }}
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const examTypesChart = document.getElementById('examTypesChart');
            const groupsStudentsChart = document.getElementById('groupsStudentsChart');

            new Chart(examTypesChart, {
                type: 'bar',
                data: {
                    labels: ['Quiz', 'Survey', 'Experiment'],
                    datasets: [{
                        label: '',
                        data: [{{ implode(",", array_column($exams_count_per_type, 'type_count')) }}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderWidth: 1,
                        barPercentage: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Exam Types'
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function(value, index, ticks) {
                                    if (Math.floor(value) === value) {
                                    return value;
                                    }
                                }
                            }
                        }
                    }
                }
            });

            function getRandomColors() {
                var colors = []
                var letters = '0123456789ABCDEF'.split('');
                var color = '#';
                for (var j = 0; j < {!! json_encode(array_column($groups_students, 'students_count')) !!}.length; j++) {
                    color = '#';
                    for (var i = 0; i < 3; i++) {
                        code = letters[Math.floor(Math.random() * 16)];
                        color += code + code;
                    }
                    colors.push(color);
                }
                return colors;
            }

            new Chart(groupsStudentsChart, {
                type: 'pie',
                data: {
                    labels: {!! json_encode(array_column($groups_students, 'name')) !!},
                    datasets: [{
                        label: '',
                        data: {!! json_encode(array_column($groups_students, 'students_count')) !!},
                        backgroundColor: getRandomColors(),
                    }],
                    hoverOffset: 4
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Students Per Group'
                        }
                    },
                }
            });
        </script>
    @endif

</x-app-layout>
