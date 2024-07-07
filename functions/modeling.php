<?php
// session_start();

// // Koneksi ke database menggunakan PDO
// $dsn = 'mysql:host=localhost;dbname=ta';
// $username = 'root';
// $password = '';
// $options = [];

// try {
//     $pdo = new PDO($dsn, $username, $password, $options);
// } catch (PDOException $e) {
//     echo 'Connection failed: ' . $e->getMessage();
// }

// // Mengambil data training dari database
// $query = $pdo->query("SELECT real_text, sentiment FROM data_training");
// $dataTraining = $query->fetchAll(PDO::FETCH_OBJ);

// // Menyiapkan dokumen dan label
// $documents = [];
// $labels = [];
// foreach ($dataTraining as $data) {
//     $documents[] = $data->real_text;
//     $labels[] = $data->sentiment;
// }

// // Implementasi tokenizer, vectorizer, tf-idf transformer, dan multinomial naive bayes classifier
// class Tokenizer {
//     public function tokenize($text) {
//         return explode(' ', $text);
//     }
// }

// class Vectorizer {
//     private $tokenizer;
//     private $vocabulary = [];

//     public function __construct($tokenizer) {
//         $this->tokenizer = $tokenizer;
//     }

//     public function fit($documents) {
//         foreach ($documents as $document) {
//             $tokens = $this->tokenizer->tokenize($document);
//             foreach ($tokens as $token) {
//                 if (!in_array($token, $this->vocabulary)) {
//                     $this->vocabulary[] = $token;
//                 }
//             }
//         }
//     }

//     public function transform($documents) {
//         $vectors = [];
//         foreach ($documents as $document) {
//             $tokens = $this->tokenizer->tokenize($document);
//             $vector = array_fill(0, count($this->vocabulary), 0);
//             foreach ($tokens as $token) {
//                 if (($index = array_search($token, $this->vocabulary)) !== false) {
//                     $vector[$index]++;
//                 }
//             }
//             $vectors[] = $vector;
//         }
//         return $vectors;
//     }
// }

// class TfIdfTransformer {
//     private $idf = [];

//     public function fit($vectors) {
//         $numDocuments = count($vectors);
//         $numTerms = count($vectors[0]);
//         for ($i = 0; $i < $numTerms; $i++) {
//             $docCount = 0;
//             foreach ($vectors as $vector) {
//                 if ($vector[$i] > 0) {
//                     $docCount++;
//                 }
//             }
//             $this->idf[$i] = log($numDocuments / ($docCount + 1));
//         }
//     }

//     public function transform($vectors) {
//         $tfidfVectors = [];
//         foreach ($vectors as $vector) {
//             $tfidfVector = [];
//             foreach ($vector as $index => $termCount) {
//                 $tf = $termCount / array_sum($vector);
//                 $tfidfVector[] = $tf * $this->idf[$index];
//             }
//             $tfidfVectors[] = $tfidfVector;
//         }
//         return $tfidfVectors;
//     }
// }

// class MultinomialNaiveBayes {
//     private $classCounts = [];
//     private $featureCounts = [];
//     private $classProbabilities = [];
//     private $featureProbabilities = [];

//     public function train($vectors, $labels) {
//         $numDocuments = count($vectors);
//         $numTerms = count($vectors[0]);
//         $uniqueLabels = array_unique($labels);

//         foreach ($uniqueLabels as $label) {
//             $this->classCounts[$label] = 0;
//             $this->featureCounts[$label] = array_fill(0, $numTerms, 0);
//         }

//         foreach ($labels as $label) {
//             $this->classCounts[$label]++;
//         }

//         foreach ($labels as $index => $label) {
//             foreach ($vectors[$index] as $termIndex => $count) {
//                 $this->featureCounts[$label][$termIndex] += $count;
//             }
//         }

//         foreach ($this->classCounts as $label => $count) {
//             $this->classProbabilities[$label] = $count / $numDocuments;
//         }

//         foreach ($this->featureCounts as $label => $counts) {
//             $totalTerms = array_sum($counts);
//             $this->featureProbabilities[$label] = array_map(function($count) use ($totalTerms, $numTerms) {
//                 return ($count + 1) / ($totalTerms + $numTerms); // Laplace smoothing
//             }, $counts);
//         }
//     }

//     public function predict($vector) {
//         $scores = [];
//         foreach ($this->classProbabilities as $label => $classProbability) {
//             $score = log($classProbability);
//             foreach ($vector as $termIndex => $count) {
//                 if ($count > 0) {
//                     $featureProbability = $this->featureProbabilities[$label][$termIndex] ?? 1 / (array_sum($this->featureCounts[$label]) + count($this->featureCounts[$label])); // Handle unknown terms
//                     $score += $count * log($featureProbability);
//                 }
//             }
//             $scores[$label] = $score;
//         }
//         return array_search(max($scores), $scores);
//     }
// }

// class MetricsCalculator {
//     public static function calculateMetrics($actualLabels, $predictedLabels) {
//         $truePositive = ['non hate speech' => 0, 'hate speech' => 0];
//         $falsePositive = ['non hate speech' => 0, 'hate speech' => 0];
//         $falseNegative = ['non hate speech' => 0, 'hate speech' => 0];
//         $trueNegative = ['non hate speech' => 0, 'hate speech' => 0];

//         $total = count($actualLabels);

//         for ($i = 0; $i < $total; $i++) {
//             foreach (['non hate speech', 'hate speech'] as $class) {
//                 if ($actualLabels[$i] == $class && $predictedLabels[$i] == $class) {
//                     $truePositive[$class]++;
//                 } elseif ($actualLabels[$i] != $class && $predictedLabels[$i] == $class) {
//                     $falsePositive[$class]++;
//                 } elseif ($actualLabels[$i] == $class && $predictedLabels[$i] != $class) {
//                     $falseNegative[$class]++;
//                 } else {
//                     $trueNegative[$class]++;
//                 }
//             }
//         }

//         $precision = [];
//         $recall = [];
//         $accuracy = [];

//         foreach (['non hate speech', 'hate speech'] as $class) {
//             $precision[$class] = $truePositive[$class] / max(1, ($truePositive[$class] + $falsePositive[$class]));
//             $recall[$class] = $truePositive[$class] / max(1, ($truePositive[$class] + $falseNegative[$class]));
//             $accuracy[$class] = ($truePositive[$class] + $trueNegative[$class]) / $total;
//         }

//         $overallAccuracy = array_sum($truePositive) / $total;

//         return [
//             'precision' => $precision,
//             'recall' => $recall,
//             'accuracy' => $accuracy,
//             'overallAccuracy' => $overallAccuracy
//         ];
//     }
// }


// // Inisialisasi komponen
// $tokenizer = new Tokenizer();
// $vectorizer = new Vectorizer($tokenizer);
// $tfidfTransformer = new TfIdfTransformer();
// $multinomialNaiveBayes = new MultinomialNaiveBayes();

// // Latih model
// $vectorizer->fit($documents);
// $vectors = $vectorizer->transform($documents);
// $tfidfTransformer->fit($vectors);
// $tfidfVectors = $tfidfTransformer->transform($vectors);
// $multinomialNaiveBayes->train($tfidfVectors, $labels);

// // Prediksi dan evaluasi
// $predictions = [];
// foreach ($tfidfVectors as $vector) {
//     $predictions[] = $multinomialNaiveBayes->predict($vector);
// }

// $metrics = MetricsCalculator::calculateMetrics($labels, $predictions);
// echo "Metrics:\n";
// echo "Precision: " . print_r($metrics['precision'], true) . "\n";
// echo "Recall: " . print_r($metrics['recall'], true) . "\n";             
// echo "Accuracy: " . print_r($metrics['accuracy'], true) . "\n";
// echo "Overall Accuracy: {$metrics['overallAccuracy']}\n";

// // Hitung total label positif dan hate speech
// $totalPositive = count(array_filter($labels, fn($label) => $label === 'non hate speech'));
// $totalNegative = count(array_filter($labels, fn($label) => $label === 'hate speech'));

// // Simpan model ke file
// $modelData = serialize([$vectorizer, $tfidfTransformer, $multinomialNaiveBayes]);
// $modelFile = 'model_' . date('d-m-Y_h-i-s-A') . '.model';
// file_put_contents($modelFile, $modelData);

// // Simpan informasi model ke database
// $query = $pdo->prepare("INSERT INTO data_model (model_name, model_path, positive_label, negative_label, created_at) VALUES (:name, :path, :totalPositive, :totalNegative, NOW())");
// $query->execute(['name' => $modelFile, 'path' => $modelFile, 'totalPositive' => $totalPositive, 'totalNegative' => $totalNegative,]);

// echo "Model berhasil disimpan.\n";

// $_SESSION['berhasil'] = 'Berhasil Modelling!';

// header("Location: " . $_SERVER['HTTP_REFERER']);
// exit;


session_start();

// Koneksi ke database menggunakan PDO
$dsn = 'mysql:host=localhost;dbname=ta';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Koneksi ke database berhasil.<br>";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Mengambil data training dari database
$query = $pdo->query("SELECT real_text, sentiment FROM data_training");
$dataTraining = $query->fetchAll(PDO::FETCH_OBJ);

if (!$dataTraining) {
    echo "Gagal mengambil data training.<br>";
    exit;
}

// Menyiapkan dokumen dan label
$documents = [];
$labels = [];
foreach ($dataTraining as $data) {
    $documents[] = $data->real_text;
    $labels[] = $data->sentiment;
}

// Implementasi tokenizer, vectorizer, tf-idf transformer, dan multinomial naive bayes classifier
class Tokenizer {
    public function tokenize($text) {
        return explode(' ', $text);
    }
}

class Vectorizer {
    private $tokenizer;
    private $vocabulary = [];

    public function __construct($tokenizer) {
        $this->tokenizer = $tokenizer;
    }

    public function fit($documents) {
        foreach ($documents as $document) {
            $tokens = $this->tokenizer->tokenize($document);
            foreach ($tokens as $token) {
                if (!in_array($token, $this->vocabulary)) {
                    $this->vocabulary[] = $token;
                }
            }
        }
    }

    public function transform($documents) {
        $vectors = [];
        foreach ($documents as $document) {
            $tokens = $this->tokenizer->tokenize($document);
            $vector = array_fill(0, count($this->vocabulary), 0);
            foreach ($tokens as $token) {
                if (($index = array_search($token, $this->vocabulary)) !== false) {
                    $vector[$index]++;
                }
            }
            $vectors[] = $vector;
        }
        return $vectors;
    }

    public function getVocabulary() {
        return $this->vocabulary;
    }
}

class TfIdfTransformer {
    private $idf = [];

    public function fit($vectors) {
        $numDocuments = count($vectors);
        $numTerms = count($vectors[0]);
        for ($i = 0; $i < $numTerms; $i++) {
            $docCount = 0;
            foreach ($vectors as $vector) {
                if ($vector[$i] > 0) {
                    $docCount++;
                }
            }
            $this->idf[$i] = log($numDocuments / ($docCount + 1));
        }
    }

    public function transform($vectors) {
        $tfidfVectors = [];
        foreach ($vectors as $vector) {
            $tfidfVector = [];
            foreach ($vector as $index => $termCount) {
                $tf = $termCount / array_sum($vector);
                $tfidfVector[] = $tf * $this->idf[$index];
            }
            $tfidfVectors[] = $tfidfVector;
        }
        return $tfidfVectors;
    }
}

class MultinomialNaiveBayes {
    private $classCounts = [];
    private $featureCounts = [];
    private $classProbabilities = [];
    private $featureProbabilities = [];

    public function train($vectors, $labels) {
        $numDocuments = count($vectors);
        $numTerms = count($vectors[0]);
        $uniqueLabels = array_unique($labels);

        foreach ($uniqueLabels as $label) {
            $this->classCounts[$label] = 0;
            $this->featureCounts[$label] = array_fill(0, $numTerms, 0);
        }

        foreach ($labels as $label) {
            $this->classCounts[$label]++;
        }

        foreach ($labels as $index => $label) {
            foreach ($vectors[$index] as $termIndex => $count) {
                $this->featureCounts[$label][$termIndex] += $count;
            }
        }

        foreach ($this->classCounts as $label => $count) {
            $this->classProbabilities[$label] = $count / $numDocuments;
        }

        foreach ($this->featureCounts as $label => $counts) {
            $totalTerms = array_sum($counts);
            $this->featureProbabilities[$label] = array_map(function($count) use ($totalTerms, $numTerms) {
                return ($count + 1) / ($totalTerms + $numTerms); // Laplace smoothing
            }, $counts);
        }
    }

    public function predict($vector) {
        $scores = [];
        foreach ($this->classProbabilities as $label => $classProbability) {
            $score = log($classProbability);
            foreach ($vector as $termIndex => $count) {
                if ($count > 0) {
                    $featureProbability = $this->featureProbabilities[$label][$termIndex] ?? 1 / (array_sum($this->featureCounts[$label]) + count($this->featureCounts[$label])); // Handle unknown terms
                    $score += $count * log($featureProbability);
                }
            }
            $scores[$label] = $score;
        }
        return array_search(max($scores), $scores);
    }
}

class MetricsCalculator {
    public static function calculateMetrics($actualLabels, $predictedLabels) {
        $truePositive = ['non hate speech' => 0, 'hate speech' => 0];
        $falsePositive = ['non hate speech' => 0, 'hate speech' => 0];
        $falseNegative = ['non hate speech' => 0, 'hate speech' => 0];
        $trueNegative = ['non hate speech' => 0, 'hate speech' => 0];

        $total = count($actualLabels);

        for ($i = 0; $i < $total; $i++) {
            foreach (['non hate speech', 'hate speech'] as $class) {
                if ($actualLabels[$i] == $class && $predictedLabels[$i] == $class) {
                    $truePositive[$class]++;
                } elseif ($actualLabels[$i] != $class && $predictedLabels[$i] == $class) {
                    $falsePositive[$class]++;
                } elseif ($actualLabels[$i] == $class && $predictedLabels[$i] != $class) {
                    $falseNegative[$class]++;
                } else {
                    $trueNegative[$class]++;
                }
            }
        }

        $precision = [];
        $recall = [];
        $accuracy = [];

        foreach (['non hate speech', 'hate speech'] as $class) {
            $precision[$class] = $truePositive[$class] / max(1, ($truePositive[$class] + $falsePositive[$class]));
            $recall[$class] = $truePositive[$class] / max(1, ($truePositive[$class] + $falseNegative[$class]));
            $accuracy[$class] = ($truePositive[$class] + $trueNegative[$class]) / $total;
        }

        $overallAccuracy = array_sum($truePositive) / $total;

        return [
            'precision' => $precision,
            'recall' => $recall,
            'accuracy' => $accuracy,
            'overallAccuracy' => $overallAccuracy
        ];
    }
}


// Inisialisasi komponen
$tokenizer = new Tokenizer();
$vectorizer = new Vectorizer($tokenizer);
$tfidfTransformer = new TfIdfTransformer();
$multinomialNaiveBayes = new MultinomialNaiveBayes();

// Latih model
$vectorizer->fit($documents);
$vectors = $vectorizer->transform($documents);
$tfidfTransformer->fit($vectors);
$tfidfVectors = $tfidfTransformer->transform($vectors);
$multinomialNaiveBayes->train($tfidfVectors, $labels);

// Prediksi dan evaluasi
$predictions = [];
foreach ($tfidfVectors as $vector) {
    $predictions[] = $multinomialNaiveBayes->predict($vector);
}

$metrics = MetricsCalculator::calculateMetrics($labels, $predictions);
echo "Metrics:\n";
echo "Precision: " . print_r($metrics['precision'], true) . "\n";
echo "Recall: " . print_r($metrics['recall'], true) . "\n";             
echo "Accuracy: " . print_r($metrics['accuracy'], true) . "\n";
echo "Overall Accuracy: {$metrics['overallAccuracy']}\n";

// Hitung total label positif dan hate speech
$totalPositive = count(array_filter($labels, fn($label) => $label === 'non hate speech'));
$totalNegative = count(array_filter($labels, fn($label) => $label === 'hate speech'));

// Simpan model ke file
$modelData = serialize([$vectorizer, $tfidfTransformer, $multinomialNaiveBayes]);
$modelFile = 'model_' . date('d-m-Y_h-i-s-A') . '.model';
file_put_contents($modelFile, $modelData);

// Simpan informasi model ke database
$query = $pdo->prepare("INSERT INTO data_model (model_name, model_path, positive_label, negative_label, created_at) VALUES (:name, :path, :totalPositive, :totalNegative, NOW())");
$query->execute(['name' => $modelFile, 'path' => $modelFile, 'totalPositive' => $totalPositive, 'totalNegative' => $totalNegative]);

echo "Model berhasil disimpan.\n";

$_SESSION['berhasil'] = 'Berhasil Modelling!';

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;