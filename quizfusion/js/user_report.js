document.addEventListener('DOMContentLoaded', function(){

    fetch('api/user_reports.php')
    .then(res => res.json())
    .then(data => {
        if(data.error) {
            alert(data.error);
            return;
        }

        // Fill top stats
        document.getElementById('totalQuizzes').textContent = data.totalQuizzes;
        document.getElementById('topCategory').textContent = data.topCategory || "—";
        document.getElementById('highestScore').textContent = data.highestScore || "—";
        document.getElementById('latestScore').textContent = data.recentAttempts.length > 0 ?
            Math.round((data.recentAttempts[0].score / data.recentAttempts[0].total_questions) * 100) + "%" : "—";

        // Fill table
        const table = document.getElementById('attemptTable');
        table.innerHTML = '';
        if(data.recentAttempts.length === 0){
            table.innerHTML = `<tr><td colspan="4" style="text-align:center;color:#6b7280;">No attempts yet.</td></tr>`;
        } else {
            data.recentAttempts.forEach(r => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${r.quiz_id}</td>
                    <td>${r.category}</td>
                    <td>${r.score} / ${r.total_questions}</td>
                    <td>${r.taken_on}</td>
                `;
                table.appendChild(row);
            });
        }

        // Pie chart
        const ctx = document.getElementById('pieChart').getContext('2d');
        if(data.chart.labels.length > 0){
            new Chart(ctx, {
                type:'pie',
                data:{
                    labels: data.chart.labels,
                    datasets:[{
                        data: data.chart.values,
                        backgroundColor: ['#ff6384','#36a2eb','#ffce56','#4bc0c0','#ab47bc','#26c6da','#ff9f40'],
                        borderColor:'#fff',
                        borderWidth:1
                    }]
                },
                options:{
                    responsive:true,
                    plugins:{
                        legend:{ position:'bottom' }
                    }
                }
            });
        }
    })
    .catch(err => console.error(err));
});
