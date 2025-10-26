fetch("get_vitals_data.php")
  .then((res) => res.json())
  .then((data) => {
    const labels = data.map((row) => row.date);
    const bp = data.map((row) => parseInt(row.blood_pressure.split("/")[0])); // systolic
    const weight = data.map((row) => row.weight);

    // Blood Pressure Chart
    new Chart(document.getElementById("bpChart"), {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Systolic Pressure",
            data: bp,
            borderWidth: 2,
            fill: false,
            tension: 0.2,
          },
        ],
      },
      options: {
        scales: {
          y: { beginAtZero: false },
        },
      },
    });

    // Weight Chart
    new Chart(document.getElementById("weightChart"), {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Weight (kg)",
            data: weight,
            borderWidth: 2,
            fill: false,
            tension: 0.2,
          },
        ],
      },
      options: {
        scales: {
          y: { beginAtZero: false },
        },
      },
    });
  });
