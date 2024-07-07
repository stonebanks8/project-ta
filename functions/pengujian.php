<?php

// $dsn = 'mysql:host=localhost;dbname=ta';
// $username = 'root';
// $password = '';
// $options = [];

// try {
//     $pdo = new PDO($dsn, $username, $password, $options);
// } catch (PDOException $e) {
//     echo 'Connection failed: ' . $e->getMessage();
//     exit;
// }

// // Definisikan kelas sebelum deserialisasi
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

//     public function getVocabulary() {
//         return $this->vocabulary;
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
//             $this->idf[$i] = log($numDocuments / ($docCount + 1)); // Menambahkan +1 untuk menghindari pembagian dengan nol
//         }
//     }

//     public function transform($vectors) {
//         $tfidfVectors = [];
//         foreach ($vectors as $vector) {
//             $tfidfVector = [];
//             $vectorSum = array_sum($vector);
//             if ($vectorSum == 0) {
//                 // Jika vectorSum adalah nol, berikan nilai default (misalnya, 0) untuk semua elemen dalam tfidfVector
//                 foreach ($vector as $index => $termCount) {
//                     $tfidfVector[] = 0;
//                 }
//             } else {
//                 foreach ($vector as $index => $termCount) {
//                     $tf = $termCount / $vectorSum;
//                     // $tfidfVector[] = $tf * $this->idf[$index];
//                 }
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

// $namaModel = isset($_POST['namaModel']) ? $_POST['namaModel'] : '';

// // Muat model dari file
// $modelFile = 'model_03-07-2024_10-33-10-PM.model';
// $modelData = file_get_contents($modelFile);
// list($vectorizer, $tfidfTransformer, $multinomialNaiveBayes) = unserialize($modelData);

// // Pastikan model memiliki metode predict
// if (!method_exists($multinomialNaiveBayes, 'predict')) {
//     die('Failed to load model or method predict does not exist.');
// }

// // Mengambil data uji dari database
// $query = $pdo->query("SELECT real_text, sentiment FROM data_testing");
// $testings = $query->fetchAll(PDO::FETCH_OBJ);

// // Inisialisasi variabel untuk True non hate speech, true hate speech, false non hate speech, false hate speech, prediksi non hate speech, dan prediksi hate speech
// $truePositive = 0;
// $falseNegative = 0;
// $trueNegative = 0;
// $falsePositive = 0;
// $predictPositive = 0;
// $predictNegative = 0;

// $counter = 1;
// $count = count($testings);

// foreach ($testings as $testing) {
//     // Ubah teks menjadi array
//     $newTextArray = [$testing->real_text];

//     // Lakukan prediksi menggunakan model yang telah dimuat
//     $vector = $vectorizer->transform($newTextArray);
//     $tfidfVector = $tfidfTransformer->transform($vector);
//     $predictedLabel = $multinomialNaiveBayes->predict($tfidfVector[0]);

//     // Ambil hasil prediksi
//     $prediction = $predictedLabel;

//     if ($testing->sentiment == "non hate speech") {
//         if ($prediction == "non hate speech") {
//             $truePositive++; // True Positive
//             $predictPositive++;
//         } else {
//             $falseNegative++; // False Negative
//             $predictNegative++;
//         }
//     } elseif ($testing->sentiment == "hate speech") {
//         if ($prediction == "hate speech") {
//             $trueNegative++; // True Negative
//             $predictNegative++;
//         } else {
//             $falsePositive++; // False Positive
//             $predictPositive++;
//         }
//     }

//     echo "$counter / $count\n";
//     $counter++;
// }

// // Mengambil data uji dari database lagi untuk menghitung vocabulary dan weight
// $query = $pdo->query("SELECT real_text FROM data_testing");
// $arrayUji = $query->fetchAll(PDO::FETCH_OBJ);
// $dataUji = [];
// foreach ($arrayUji as $uji) {
//     $dataUji[] = $uji->real_text;
// }

// $tokenizer = new Tokenizer();
// $vectorizer = new Vectorizer($tokenizer);
// $vectorizer->fit($dataUji);
// $vocab = $vectorizer->getVocabulary();

// $transformer = new TfIdfTransformer();
// $tfidfVectors = $transformer->transform($vectorizer->transform($dataUji));

// $weight = [];
// foreach ($tfidfVectors as $vector) {
//     $weight[] = array_sum($vector);
// }

// $jumlahSentimen = isset($_POST['jumlahSentimen']) ? $_POST['jumlahSentimen'] : '';
// $trainingnon hate speech = isset($_POST['trainingnon hate speech']) ? $_POST['trainingnon hate speech'] : '';
// $traininghate speech = isset($_POST['traininghate speech']) ? $_POST['traininghate speech'] : '';

// $data = [
//     'created_at' => date('Y-m-d H:i:s'),
//     'true_positive' => $truePositive,
//     'false_negative' => $falseNegative,
//     'true_negative' => $trueNegative,
//     'false_positive' => $falsePositive,
//     'data_testing' => count($testings),
//     'data_training' => $jumlahSentimen,
//     'data_training_positive' => $trainingnon hate speech,
//     'data_training_negative' => $traininghate speech,
//     'predict_positive' => $predictPositive,
//     'predict_negative' => $predictNegative,
//     'vocabulary' => json_encode($vocab),
//     'vocab_weight' => json_encode($weight),
// ];

// // Cek apakah ada riwayat sebelumnya
// $query = $pdo->query("SELECT * FROM riwayat");
// if ($query->rowCount() == 0) {
//     $insertQuery = "INSERT INTO riwayat (created_at, true_positive, false_negative, true_negative, false_positive, data_testing, data_training, data_training_positive, data_training_negative, predict_positive, predict_negative, vocabulary, vocab_weight) VALUES (:created_at, :true_positive, :false_negative, :true_negative, :false_positive,  :data_testing, :data_training, :data_training_positive, :data_training_negative, :predict_positive, :predict_negative, :vocabulary, :vocab_weight)";
//     $stmt = $pdo->prepare($insertQuery);
//     $stmt->execute($data);
//     echo "Berhasil, Sukses Melakukan Pengujian\n";
// } else {
//     $updateQuery = "UPDATE riwayat SET created_at = :created_at, true_positive = :true_positive, false_negative = :false_negative, true_negative = :true_negative, false_positive = :false_positive, data_testing = :data_testing, data_training = :data_training, data_training_positive = :data_training_positive, data_training_negative = :data_training_negative, predict_positive = :predict_positive, predict_negative = :predict_negative, vocabulary = :vocabulary, vocab_weight = :vocab_weight";
//     $stmt = $pdo->prepare($updateQuery);
//     $stmt->execute($data);
//     echo "Berhasil, Sukses Melakukan Pengujian\n";
// }

// header("location: " . $_SERVER['HTTP_REFERER']);         


$dsn = 'mysql:host=localhost;dbname=ta';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Definisikan kelas sebelum deserialisasi
class Tokenizer
{
    public function tokenize($text)
    {
        return explode(' ', $text);
    }
}

class Vectorizer
{
    private $tokenizer;
    private $vocabulary = [];

    public function __construct($tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    public function fit($documents)
    {
        foreach ($documents as $document) {
            $tokens = $this->tokenizer->tokenize($document);
            foreach ($tokens as $token) {
                if (!in_array($token, $this->vocabulary)) {
                    $this->vocabulary[] = $token;
                }
            }
        }
    }

    public function transform($documents)
    {
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

    public function getVocabulary()
    {
        return $this->vocabulary;
    }
}

class TfIdfTransformer
{
    private $idf = [];

    public function fit($vectors)
    {
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

    public function transform($vectors)
    {
        $tfidfVectors = [];
        foreach ($vectors as $vector) {
            $tfidfVector = [];
            foreach ($vector as $index => $termCount) {
                if (isset($this->idf[$index])) { // Memeriksa apakah $index ada di $this->idf
                    $tf = $termCount / array_sum($vector);
                    $tfidfVector[] = $tf * $this->idf[$index];
                } else {
                    // Tindakan jika $index tidak ada di $this->idf, misalnya:
                    $tfidfVector[] = 0; // Atau Anda dapat memilih untuk melewatkan indeks ini
                }
            }
            $tfidfVectors[] = $tfidfVector;
        }
        return $tfidfVectors;
    }
}

class MultinomialNaiveBayes
{
    private $classCounts = [];
    private $featureCounts = [];
    private $classProbabilities = [];
    private $featureProbabilities = [];

    public function train($vectors, $labels)
    {
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
            $this->featureProbabilities[$label] = array_map(function ($count) use ($totalTerms, $numTerms) {
                return ($count + 1) / ($totalTerms + $numTerms); // Laplace smoothing
            }, $counts);
        }
    }

    public function predict($vector)
    {
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

$namaModel = isset($_POST['namaModel']) ? $_POST['namaModel'] : '';

// Muat model dari file
$modelFile = 'model_06-07-2024_06-58-04-AM.model';
$modelData = file_get_contents($modelFile);
list($vectorizer, $tfidfTransformer, $multinomialNaiveBayes) = unserialize($modelData);

// Pastikan model memiliki metode predict
if (!method_exists($multinomialNaiveBayes, 'predict')) {
    die('Failed to load model or method predict does not exist.');
}

// Mengambil data uji dari database
// $query = $pdo->query("SELECT real_text, sentiment FROM data_testing WHERE sentiment IN ('non hate speech', 'hate speech')");
$query = $pdo->query("SELECT real_text, sentiment FROM data_testing");
$testings = $query->fetchAll(PDO::FETCH_OBJ);

// Inisialisasi variabel untuk True non hate speech, true hate speech, false non hate speech, false hate speech, prediksi non hate speech, dan prediksi hate speech
$truePositive = 0;
$falseNegative = 0;
$trueNegative = 0;
$falsePositive = 0;
$predictPositive = 0;
$predictNegative = 0;

$counter = 1;
$count = count($testings);

foreach ($testings as $testing) {
    // Ubah teks menjadi array
    $newTextArray = [$testing->real_text];

    // Lakukan prediksi menggunakan model yang telah dimuat
    $vector = $vectorizer->transform($newTextArray);
    $tfidfVector = $tfidfTransformer->transform($vector);
    $predictedLabel = $multinomialNaiveBayes->predict($tfidfVector[0]);

    // Ambil hasil prediksi
    $prediction = $predictedLabel;

    if ($testing->sentiment == "non hate speech") {
        if ($prediction == "non hate speech") {
            $truePositive++; // True Positive
            $predictPositive++;
        } else {
            $falseNegative++; // False Negative
            $predictNegative++;
        }
    } elseif ($testing->sentiment == "hate speech") {
        if ($prediction == "hate speech") {
            $trueNegative++; // True Negative
            $predictNegative++;
        } else {
            $falsePositive++; // False Positive
            $predictPositive++;
        }
    }
    echo "$counter / $count\n";
    $counter++;
}

// Mengambil data uji dari database lagi untuk menghitung vocabulary dan weight
// $query = $pdo->query("SELECT real_text FROM data_testing WHERE sentiment IN ('non hate speech', 'hate speech')");
$query = $pdo->query("SELECT real_text FROM data_testing");
$arrayUji = $query->fetchAll(PDO::FETCH_OBJ);
$dataUji = [];
foreach ($arrayUji as $uji) {
    $dataUji[] = $uji->real_text;
}

$tokenizer = new Tokenizer();
$vectorizer = new Vectorizer($tokenizer);
$vectorizer->fit($dataUji);
$vocab = $vectorizer->getVocabulary();

$transformer = new TfIdfTransformer();
$tfidfVectors = $transformer->transform($vectorizer->transform($dataUji));

$weight = [];
foreach ($tfidfVectors as $vector) {
    $weight[] = array_sum($vector);
}

// $jumlahSentimen = isset($_POST['jumlahSentimen']) ? $_POST['jumlahSentimen'] : '';
// $trainingnon hate speech = isset($_POST['trainingnon hate speech']) ? $_POST['trainingnon hate speech'] : '';
// $traininghate speech = isset($_POST['traininghate speech']) ? $_POST['traininghate speech'] : '';
$jumlahSentimen = 342;
$trainingpositive = 10;
$trainingnegative = 100;

echo "true positive" . $truePositive;
echo "true negative " . $trueNegative;

$data = [
    'created_at' => date('Y-m-d H:i:s'),
    'true_positive' => $truePositive,
    'false_negative' => $falseNegative,
    'true_negative' => $trueNegative,
    'false_positive' => $falsePositive,
    'data_testing' => count($testings),
    'data_training' => $jumlahSentimen,
    'data_training_positive' => $trainingpositive,
    'data_training_negative' => $trainingnegative,
    'predict_positive' => $predictPositive,
    'predict_negative' => $predictNegative,
    'vocabulary' => json_encode($vocab),
    'vocab_weight' => json_encode($weight),
];

// Cek apakah ada riwayat sebelumnya
$query = $pdo->query("SELECT * FROM riwayat");
if ($query->rowCount() == 0) {
    $insertQuery = "INSERT INTO riwayat (created_at, true_positive, false_negative, true_negative, false_positive, data_testing, data_training, data_training_positive, data_training_negative, predict_positive, predict_negative, vocabulary, vocab_weight) VALUES (:created_at, :true_positive, :false_negative, :true_negative, :false_positive, :data_testing, :data_training, :data_training_positive, :data_training_negative, :predict_positive, :predict_negative, :vocabulary, :vocab_weight)";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute($data);
    echo "Berhasil, Sukses Melakukan Pengujian\n";
} else {
    $updateQuery = "UPDATE riwayat SET created_at = :created_at, true_positive = :true_positive, false_negative = :false_negative, true_negative = :true_negative, false_positive = :false_positive, data_testing = :data_testing, data_training = :data_training, data_training_positive = :data_training_positive, data_training_negative = :data_training_negative, predict_positive = :predict_positive, predict_negative = :predict_negative, vocabulary = :vocabulary, vocab_weight = :vocab_weight";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute($data);
    echo "Berhasil, Sukses Melakukan Pengujian\n";
}

header("location: " . $_SERVER['HTTP_REFERER']);
