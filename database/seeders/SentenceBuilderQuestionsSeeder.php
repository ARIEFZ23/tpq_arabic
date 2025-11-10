<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class SentenceBuilderQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Memasukkan soal "Arabic Sentence Builder"...');
        
        $sentences = [
            // ==========================================
            // JUMLAH ISMIYAH (Nominal Sentence)
            // ==========================================
            [
                'category' => 'ismiyyah',
                'correct' => 'البيتُ كبيرٌ',
                'scrambled' => ['كبيرٌ', 'البيتُ'],
                'translation' => 'Rumah itu besar.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الولدُ ذكيٌ',
                'scrambled' => ['ذكيٌ', 'الولدُ'],
                'translation' => 'Anak laki-laki itu pandai.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'السماءُ صافيةٌ',
                'scrambled' => ['صافيةٌ', 'السماءُ'],
                'translation' => 'Langit itu cerah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الكتابُ مفتوحٌ',
                'scrambled' => ['مفتوحٌ', 'الكتابُ'],
                'translation' => 'Buku itu terbuka.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الماءُ باردٌ',
                'scrambled' => ['باردٌ', 'الماءُ'],
                'translation' => 'Air itu dingin.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'المعلمُ حاضرٌ',
                'scrambled' => ['حاضرٌ', 'المعلمُ'],
                'translation' => 'Guru itu hadir.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الطالبةُ مجتهدةٌ',
                'scrambled' => ['مجتهدةٌ', 'الطالبةُ'],
                'translation' => 'Siswi itu rajin.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الامتحانُ صعبٌ',
                'scrambled' => ['صعبٌ', 'الامتحانُ'],
                'translation' => 'Ujian itu sulit.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الدرسُ سهلٌ',
                'scrambled' => ['سهلٌ', 'الدرسُ'],
                'translation' => 'Pelajaran itu mudah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'المكتبةُ واسعةٌ',
                'scrambled' => ['واسعةٌ', 'المكتبةُ'],
                'translation' => 'Perpustakaan itu luas.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الطعامُ لذيذٌ',
                'scrambled' => ['لذيذٌ', 'الطعامُ'],
                'translation' => 'Makanan itu lezat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الصديقُ وفيٌ',
                'scrambled' => ['وفيٌ', 'الصديقُ'],
                'translation' => 'Teman itu setia.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الجوُّ حارٌ',
                'scrambled' => ['حارٌ', 'الجوُّ'],
                'translation' => 'Cuaca itu panas.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الشارعُ نظيفٌ',
                'scrambled' => ['نظيفٌ', 'الشارعُ'],
                'translation' => 'Jalan itu bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الحديقةُ جميلةٌ',
                'scrambled' => ['جميلةٌ', 'الحديقةُ'],
                'translation' => 'Taman itu indah.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'القلمُ جديدٌ',
                'scrambled' => ['جديدٌ', 'القلمُ'],
                'translation' => 'Pulpen itu baru.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الغرفةُ نظيفةٌ',
                'scrambled' => ['نظيفةٌ', 'الغرفةُ'],
                'translation' => 'Kamar itu bersih.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'المسجدُ قريبٌ',
                'scrambled' => ['قريبٌ', 'المسجدُ'],
                'translation' => 'Masjid itu dekat.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'الوقتُ ثمينٌ',
                'scrambled' => ['ثمينٌ', 'الوقتُ'],
                'translation' => 'Waktu itu berharga.',
            ],
            [
                'category' => 'ismiyyah',
                'correct' => 'اللغةُ العربيةُ مهمةٌ',
                'scrambled' => ['مهمةٌ', 'العربيةُ', 'اللغةُ'],
                'translation' => 'Bahasa Arab itu penting.',
            ],

            // ==========================================
            // JUMLAH FILIYYAH (Verbal Sentence)
            // ==========================================
            [
                'category' => 'filiyyah',
                'correct' => 'ذهبَ الولدُ الى المدرسة',
                'scrambled' => ['المدرسة', 'الولدُ', 'ذهبَ', 'الى'],
                'translation' => 'Anak laki-laki pergi ke sekolah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'قرأَ الطالبُ الكتابَ',
                'scrambled' => ['الكتابَ', 'الطالبُ', 'قرأَ'],
                'translation' => 'Siswa itu membaca buku.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شربَ الرجلُ الماءَ',
                'scrambled' => ['الماءَ', 'الرجلُ', 'شربَ'],
                'translation' => 'Pria itu meminum air.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أكلَت البنتُ التفاحةَ',
                'scrambled' => ['التفاحةَ', 'البنتُ', 'أكلَت'],
                'translation' => 'Anak perempuan itu memakan apel.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'فتحَ الأبُ البابَ',
                'scrambled' => ['البابَ', 'الأبُ', 'فتحَ'],
                'translation' => 'Ayah itu membuka pintu.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'كتبَ الطالبُ الواجبَ',
                'scrambled' => ['الواجبَ', 'الطالبُ', 'كتبَ'],
                'translation' => 'Siswa itu menulis PR.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'درسَ الولدُ الدرسَ',
                'scrambled' => ['الدرسَ', 'الولدُ', 'درسَ'],
                'translation' => 'Anak laki-laki itu belajar pelajaran.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نامَ الطفلُ في السريرِ',
                'scrambled' => ['السريرِ', 'في', 'الطفلُ', 'نامَ'],
                'translation' => 'Anak itu tidur di tempat tidur.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'لعبَ الأولادُ في الملعبِ',
                'scrambled' => ['الملعبِ', 'في', 'الأولادُ', 'لعبَ'],
                'translation' => 'Anak-anak bermain di lapangan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'ساعدَ الطالبُ صديقَهُ',
                'scrambled' => ['صديقَهُ', 'الطالبُ', 'ساعدَ'],
                'translation' => 'Siswa itu menolong temannya.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'زارَ الأستاذُ المريضَ',
                'scrambled' => ['المريضَ', 'الأستاذُ', 'زارَ'],
                'translation' => 'Ustadz itu mengunjungi orang sakit.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'حفظَ الطالبُ القرآنَ',
                'scrambled' => ['القرآنَ', 'الطالبُ', 'حفظَ'],
                'translation' => 'Siswa itu menghafal Al-Quran.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'صلى المسلمُ في المسجدِ',
                'scrambled' => ['المسجدِ', 'في', 'المسلمُ', 'صلى'],
                'translation' => 'Muslim itu sholat di masjid.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'طبخَت الأمُّ الطعامَ',
                'scrambled' => ['الطعامَ', 'الأمُّ', 'طبخَت'],
                'translation' => 'Ibu itu memasak makanan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'غسلَت البنتُ الملابسَ',
                'scrambled' => ['الملابسَ', 'البنتُ', 'غسلَت'],
                'translation' => 'Anak perempuan itu mencuci pakaian.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'سافرَ الرجلُ الى مكةَ',
                'scrambled' => ['مكةَ', 'الى', 'الرجلُ', 'سافرَ'],
                'translation' => 'Pria itu bepergian ke Makkah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'جلسَ الطالبُ على الكرسيِ',
                'scrambled' => ['الكرسيِ', 'على', 'الطالبُ', 'جلسَ'],
                'translation' => 'Siswa itu duduk di kursi.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'ركبَ الولدُ الدراجةَ',
                'scrambled' => ['الدراجةَ', 'الولدُ', 'ركبَ'],
                'translation' => 'Anak laki-laki itu mengendarai sepeda.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رسمَ الطالبُ الصورةَ',
                'scrambled' => ['الصورةَ', 'الطالبُ', 'رسمَ'],
                'translation' => 'Siswa itu menggambar lukisan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'حملَ الرجلُ الحقيبةَ',
                'scrambled' => ['الحقيبةَ', 'الرجلُ', 'حملَ'],
                'translation' => 'Pria itu membawa tas.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نظفَت المرأةُ البيتَ',
                'scrambled' => ['البيتَ', 'المرأةُ', 'نظفَت'],
                'translation' => 'Wanita itu membersihkan rumah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'استيقظَ الطالبُ مبكراً',
                'scrambled' => ['مبكراً', 'الطالبُ', 'استيقظَ'],
                'translation' => 'Siswa itu bangun pagi.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'اشترى الأبُ الهديةَ',
                'scrambled' => ['الهديةَ', 'الأبُ', 'اشترى'],
                'translation' => 'Ayah itu membeli hadiah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'سمعَ الطالبُ الشرحَ',
                'scrambled' => ['الشرحَ', 'الطالبُ', 'سمعَ'],
                'translation' => 'Siswa itu mendengar penjelasan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'فهمَ الولدُ السؤالَ',
                'scrambled' => ['السؤالَ', 'الولدُ', 'فهمَ'],
                'translation' => 'Anak laki-laki itu memahami pertanyaan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'نجحَ الطالبُ في الامتحانِ',
                'scrambled' => ['الامتحانِ', 'في', 'الطالبُ', 'نجحَ'],
                'translation' => 'Siswa itu lulus dalam ujian.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'أجابَ الطالبُ على السؤالِ',
                'scrambled' => ['السؤالِ', 'على', 'الطالبُ', 'أجابَ'],
                'translation' => 'Siswa itu menjawab pertanyaan.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'شكرَ الولدُ المعلمَ',
                'scrambled' => ['المعلمَ', 'الولدُ', 'شكرَ'],
                'translation' => 'Anak laki-laki itu berterima kasih kepada guru.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'رجعَ الطالبُ الى البيتِ',
                'scrambled' => ['البيتِ', 'الى', 'الطالبُ', 'رجعَ'],
                'translation' => 'Siswa itu kembali ke rumah.',
            ],
            [
                'category' => 'filiyyah',
                'correct' => 'قابلَ الطالبُ صديقَهُ',
                'scrambled' => ['صديقَهُ', 'الطالبُ', 'قابلَ'],
                'translation' => 'Siswa itu bertemu temannya.',
            ],
        ];

        foreach ($sentences as $s) {
            Question::firstOrCreate(
                // Kriteria untuk mencari soal yang sudah ada
                [
                    'category' => 'sentence_builder',
                    'question_text' => $s['correct'],
                ],
                // Data yang akan disimpan jika tidak ditemukan
                [
                    'game_id' => null,
                    'correct_answer' => $s['translation'], // Simpan terjemahan sebagai jawaban benar untuk hint
                    'options' => json_encode($s['scrambled']),
                    'location_name' => null,
                ]
            );
        }

        $this->command->info('✅ Seeder "Arabic Sentence Builder" selesai.');
        $this->command->info('📊 Total: ' . count($sentences) . ' kalimat telah ditambahkan.');
    }
}