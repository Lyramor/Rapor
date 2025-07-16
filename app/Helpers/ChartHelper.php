<?php
namespace App\Helpers;

use Spatie\Browsershot\Browsershot;

class ChartHelper
{
    public static function generateRadarChartBase64($labels, $values)
    {
        $chartId = 'radarChart_' . uniqid();

        $html = '
        <html>
        <head>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <style>body { margin: 0; }</style>
        </head>
        <body>
            <canvas id="' . $chartId . '" width="400" height="400"></canvas>
            <script>
                const ctx = document.getElementById("' . $chartId . '").getContext("2d");
                new Chart(ctx, {
                    type: "radar",
                    data: {
                        labels: ' . json_encode($labels) . ',
                        datasets: [{
                            label: "Nilai",
                            data: ' . json_encode($values) . ',
                            backgroundColor: "rgba(54, 162, 235, 0.2)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            r: {
                                min: 0,
                                max: 5,
                                stepSize: 2,
                            }
                        }
                    }
                });
            </script>
        </body>
        </html>';

        $base64 = Browsershot::html($html)
            ->windowSize(300, 300)
            ->setNodeBinary('/opt/homebrew/bin/node') // ← Sesuaikan dengan path `node` kamu
            ->setNpmBinary('/opt/homebrew/bin/npm')   // ← Sesuaikan juga
            ->deviceScaleFactor(10)
            ->screenshot();

        return 'data:image/png;base64,' . base64_encode($base64);
    }
}
