/**
 * SDN Cikereteg 01 - Core JavaScript Module
 */

document.addEventListener('DOMContentLoaded', () => {
  initMobileMenu();
  initTeacherModalEvents();
  initGalleryEvents();
  initPpdbEvents();
  initContactEvents();
});

/* 1. Mobile Menu Drawer Toggle */
function initMobileMenu() {
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileDrawer = document.getElementById('mobileDrawer');
  const mobileMenuIcon = document.getElementById('mobileMenuIcon');

  if (mobileMenuBtn && mobileDrawer) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileDrawer.classList.toggle('hidden');
      if (mobileDrawer.classList.contains('hidden')) {
        if (mobileMenuIcon) mobileMenuIcon.textContent = 'menu';
      } else {
        if (mobileMenuIcon) mobileMenuIcon.textContent = 'close';
      }
    });
  }
}

/* 2. Profile Page Tabs (Visi / Misi / Budaya) */
function switchProfileTab(tabName) {
  const tabVisi = document.getElementById('tabContentVisi');
  const tabMisi = document.getElementById('tabContentMisi');
  const tabBudaya = document.getElementById('tabContentBudaya');

  const btnVisi = document.getElementById('tabBtnVisi');
  const btnMisi = document.getElementById('tabBtnMisi');
  const btnBudaya = document.getElementById('tabBtnBudaya');

  if (!tabVisi || !tabMisi || !tabBudaya) return;

  // Reset all content
  tabVisi.classList.add('hidden');
  tabMisi.classList.add('hidden');
  tabBudaya.classList.add('hidden');

  // Reset styling
  [btnVisi, btnMisi, btnBudaya].forEach(btn => {
    if (btn) btn.className = "px-5 py-2.5 rounded-xl font-label-lg text-label-lg font-bold transition-all text-on-surface-variant hover:text-primary flex items-center gap-2";
  });

  const activeClass = "px-5 py-2.5 rounded-xl font-label-lg text-label-lg font-bold transition-all bg-primary text-on-primary shadow-sm flex items-center gap-2";

  if (tabName === 'visi' && btnVisi) {
    tabVisi.classList.remove('hidden');
    btnVisi.className = activeClass;
  } else if (tabName === 'misi' && btnMisi) {
    tabMisi.classList.remove('hidden');
    btnMisi.className = activeClass;
  } else if (tabName === 'budaya' && btnBudaya) {
    tabBudaya.classList.remove('hidden');
    btnBudaya.className = activeClass;
  }
}

/* 3. History Timeline Switcher */
const timelineData = {
  1985: {
    badge: "Tahun 1985 - Awal Pendirian",
    title: "Perintisan SDN Cikereteg 01",
    desc: "SDN Cikereteg 01 resmi didirikan untuk melayani kebutuhan pendidikan dasar anak-anak Desa Cikereteg, Kec. Caringin, Kab. Bogor dengan dedikasi para guru perintis.",
    img: "https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop",
    highlights: [
      "Penerimaan murid pertama warga sekitar Desa Cikereteg",
      "Pembangunan 3 ruang kelas dasar & ruang guru",
      "Pelopor pendidikan dasar formal di wilayah Caringin"
    ]
  },
  1995: {
    badge: "Tahun 1995 - Perluasan Sarana",
    title: "Pembangunan Perpustakaan & Lapangan Upacara",
    desc: "Melengkapi fasilitas belajar dengan ruang perpustakaan sekolah, penambahan ruang kelas baru, serta lapangan upacara dan olahraga yang asri.",
    img: "https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=800&auto=format&fit=crop",
    highlights: [
      "Peresmian Gedung Perpustakaan & Ruang UKS",
      "Perluasan rombel menjadi 6 tingkat kelas penuh (Kelas 1 - 6)",
      "Pramuka Gudep Cikereteg aktif berprestasi"
    ]
  },
  2006: {
    badge: "Tahun 2006 - Program Peningkatan Sarana",
    title: "Pembangunan Laboratorium Komputer Dasar & Perpustakaan Digital",
    desc: "Pemerintah melengkapi sarana pembelajaran TIK tingkat dasar untuk mengenalkan literasi digital awal kepada peserta didik jenjang sekolah dasar.",
    img: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop",
    highlights: [
      "Pengadaan perangkat komputer untuk pengenalan TIK dasar",
      "Peningkatan koleksi buku cerita anak & ensiklopedia ilmu pengetahuan",
      "Pelatihan literasi membaca bagi siswa kelas awal dan tinggi"
    ]
  },
  2016: {
    badge: "Tahun 2016 - Sekolah Adiwiyata & UKS",
    title: "Revitalisasi Lingkungan Sekolah Hijau & Ramah Anak",
    desc: "Mencanangkan program Sekolah Sehat, revitalisasi taman toga, sanitasi higienis, serta kemitraan terpadu bersama Puskesmas Caringin.",
    img: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=800&auto=format&fit=crop",
    highlights: [
      "Penghargaan rintisan Sekolah Adiwiyata Kabupaten Bogor",
      "Penguatan dokter cilik dan layanan UKS sekolah",
      "Penerapan zona ramah anak dan bebas asap rokok"
    ]
  },
  2024: {
    badge: "Tahun 2024 - Kurikulum Merdeka",
    title: "Implementasi Penuh Kurikulum Merdeka Fase A, B, & C",
    desc: "Mengimplementasikan pembelajaran berpusat pada murid: Fase A (Kelas 1-2), Fase B (Kelas 3-4), dan Fase C (Kelas 5-6) disertai gelar karya Projek P5.",
    img: "https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop",
    highlights: [
      "Penerapan pembelajaran diferensiasi ramah anak",
      "Gelar Karya P5 kearifan lokal & gaya hidup berkelanjutan",
      "Penguatan literasi-numerasi berbasis permainan edukatif"
    ]
  },
  2026: {
    badge: "Tahun 2026 - Puncak Prestasi",
    title: "Raihan Akreditasi A & Prestasi Tingkat Kabupaten",
    desc: "Mempertahankan Akreditasi A (Unggul) dari BAN-S/M, membina ratusan siswa berprestasi di ajang OSN, O2SN, FLS2N, dan kepramukaan.",
    img: "https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=800&auto=format&fit=crop",
    highlights: [
      "Nilai Akreditasi A Unggul",
      "Lulusan 100% terserap melanjutkan ke jenjang pendidikan lanjutan unggulan",
      "Sekolah Ramah Anak bersertifikat & Zero Bullying"
    ]
  }
};

function selectTimelineYear(year) {
  const data = timelineData[year];
  if (!data) return;

  [1985, 1995, 2006, 2016, 2024, 2026].forEach(y => {
    const btn = document.getElementById(`yearBtn${y}`);
    if (btn) {
      if (y === year) {
        btn.className = "px-5 py-3 font-label-lg text-label-lg font-bold border-b-2 border-primary text-primary transition-all";
      } else {
        btn.className = "px-5 py-3 font-label-lg text-label-lg font-bold border-b-2 border-transparent text-on-surface-variant hover:text-primary transition-all";
      }
    }
  });

  const container = document.getElementById('timelineCardContent');
  if (!container) return;

  container.style.opacity = '0.3';
  setTimeout(() => {
    const badgeEl = document.getElementById('timelineYearBadge');
    const titleEl = document.getElementById('timelineTitle');
    const descEl = document.getElementById('timelineDesc');
    const imgEl = document.getElementById('timelineImg');
    const highlightsContainer = document.getElementById('timelineHighlights');

    if (badgeEl) badgeEl.textContent = data.badge;
    if (titleEl) titleEl.textContent = data.title;
    if (descEl) descEl.textContent = data.desc;
    if (imgEl) imgEl.src = data.img;

    if (highlightsContainer) {
      highlightsContainer.innerHTML = data.highlights.map(item => `
        <li class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[16px] text-tertiary-container">check_circle</span>
          <span>${item}</span>
        </li>
      `).join('');
    }

    container.style.opacity = '1';
  }, 150);
}

/* 4. Teacher Filter & Search System */
let currentFilter = 'all';

function setTeacherFilter(category) {
  currentFilter = category;
  
  const btnAll = document.getElementById('filterAll');
  const btnKelas = document.getElementById('filterKelas');
  const btnMapel = document.getElementById('filterMapel');
  const btnTendik = document.getElementById('filterTendik');

  const inactiveStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-surface-container-high text-on-surface-variant hover:text-primary transition-all";
  const activeStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-primary text-on-primary transition-all";

  [btnAll, btnKelas, btnMapel, btnTendik].forEach(b => {
    if (b) b.className = inactiveStyle;
  });

  if (category === 'all' && btnAll) btnAll.className = activeStyle;
  if (category === 'guru-kelas' && btnKelas) btnKelas.className = activeStyle;
  if (category === 'guru-mapel' && btnMapel) btnMapel.className = activeStyle;
  if (category === 'tendik' && btnTendik) btnTendik.className = activeStyle;

  filterTeachers();
}

function filterTeachers() {
  const searchInputEl = document.getElementById('teacherSearchInput');
  const searchInput = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
  const cards = document.querySelectorAll('.teacher-card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cat = card.getAttribute('data-category');
    const name = card.getAttribute('data-name') ? card.getAttribute('data-name').toLowerCase() : '';
    const subject = card.getAttribute('data-subject') ? card.getAttribute('data-subject').toLowerCase() : '';

    const matchCategory = (currentFilter === 'all' || cat === currentFilter);
    const matchSearch = (name.includes(searchInput) || subject.includes(searchInput));

    if (matchCategory && matchSearch) {
      card.classList.remove('hidden');
      card.classList.add('flex');
      visibleCount++;
    } else {
      card.classList.add('hidden');
      card.classList.remove('flex');
    }
  });

  const noMatchMessage = document.getElementById('noMatchMessage');
  if (noMatchMessage) {
    if (visibleCount === 0) {
      noMatchMessage.classList.remove('hidden');
    } else {
      noMatchMessage.classList.add('hidden');
    }
  }
}

/* 5. Teacher Detail Modal Data & Controller */
const teacherDetails = [
  {
    name: "Siti Rahmawati, S.Pd.",
    roleBadge: "Guru Kelas 1A",
    subject: "Guru Kelas 1 & Koordinator Literasi Awal",
    edu: "S1 Pendidikan Guru Sekolah Dasar (UNJ) • Sertifikasi Pendidik 2014",
    img: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop",
    motto: "Mendidik kelas 1 membutuhkan kesabaran ekstra dan pendekatan keibuan agar proses transisi dari TK ke SD menjadi pengalaman yang menyenangkan bagi anak.",
    hours: "Senin & Kamis, 13.00 - 14.30 WIB"
  },
  {
    name: "Budi Santoso, S.Pd.",
    roleBadge: "Guru Kelas 6B",
    subject: "Guru Kelas 6 & Wakasek Kesiswaan",
    edu: "S1 Pendidikan Sains (UPI Bandung) • Pelatih Pramuka Mahir Dasar",
    img: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600&auto=format&fit=crop",
    motto: "Mempersiapkan siswa tingkat akhir bukan hanya soal kelulusan ujian, tetapi membentuk mental kepemimpinan dan rasa percaya diri menghadapi jenjang pendidikan berikutnya.",
    hours: "Selasa & Jumat, 13.30 - 15.00 WIB"
  },
  {
    name: "Rina Kartika, M.Hum.",
    roleBadge: "Guru Mapel English",
    subject: "Guru Bahasa Inggris & Program Cambridge Primary",
    edu: "S2 Linguistik Terapan (Universitas Indonesia) • TESOL Certified",
    img: "https://images.unsplash.com/photo-1580894732413-87b1c312740d?q=80&w=600&auto=format&fit=crop",
    motto: "Learning English should be interactive through storytelling, songs, and roleplay so students feel natural and confident communicating.",
    hours: "Rabu, 12.30 - 14.00 WIB"
  },
  {
    name: "Aris Munandar, S.Kom.",
    roleBadge: "Guru Koding & Robotik",
    subject: "Guru Informatika, Robotik & Pembina STEM",
    edu: "S1 Teknik Informatika (ITB) • Certified Educator Scratch & Python",
    img: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop",
    motto: "Koding mengajarkan anak cara berpikir logis dan sistematis. Lewat gim dan animasi sederhana, logika pemecahan masalah terbangun sejak dini.",
    hours: "Kamis & Jumat, 14.00 - 15.30 WIB"
  },
  {
    name: "Dewi Sartika, S.Pd.",
    roleBadge: "Guru Kelas 3C",
    subject: "Guru Kelas 3 & Pembina Seni",
    edu: "S1 PGSD (Universitas Negeri Jakarta) • Pelatih Seni Budaya",
    img: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=600&auto=format&fit=crop",
    motto: "Seni dan pendidikan karakter berjalan seiring dalam menyeimbangkan kecerdasan otak kiri dan otak kanan anak.",
    hours: "Selasa, 13.00 - 14.30 WIB"
  },
  {
    name: "Eko Prasetyo, S.Pd.",
    roleBadge: "Guru Kelas 4A",
    subject: "Guru Kelas 4 & Pembina Olahraga Siswa",
    edu: "S1 Pendidikan Olahraga & Kesehatan (UNJ)",
    img: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop",
    motto: "Jiwa yang sehat melahirkan pikiran yang jernih. Melalui olahraga, anak-anak belajar nilai sportivitas dan pantang menyerah.",
    hours: "Senin & Rabu, 13.30 - 15.00 WIB"
  },
  {
    name: "Nurul Hidayah, S.Psi., M.Psi.",
    roleBadge: "Psikolog Sekolah",
    subject: "Koordinator Layanan BK & Pendampingan Anak",
    edu: "S2 Psikologi Perkembangan Anak (Universitas Indonesia)",
    img: "https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?q=80&w=600&auto=format&fit=crop",
    motto: "Setiap anak unik dengan potensi dan emosi yang perlu didengar. Ruang konseling kami selalu terbuka aman dan hangat.",
    hours: "Senin s/d Jumat (Dengan Janji Temu via Sekretariat)"
  },
  {
    name: "Bambang Herdian, S.E.",
    roleBadge: "Kepala TU",
    subject: "Kepala Administrasi, Keuangan & Layanan Orang Tua",
    edu: "S1 Akuntansi (Universitas Pancasila)",
    img: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600&auto=format&fit=crop",
    motto: "Layanan administrasi cepat, transparan, dan komunikatif untuk memberikan kenyamanan maksimal bagi seluruh orang tua siswa.",
    hours: "Senin - Jumat, 07.30 - 15.00 WIB"
  }
];

function openTeacherModal(index) {
  const data = teacherDetails[index];
  if (!data) return;

  const modalName = document.getElementById('modalName');
  const modalRoleBadge = document.getElementById('modalRoleBadge');
  const modalSubject = document.getElementById('modalSubject');
  const modalEdu = document.getElementById('modalEdu');
  const modalMotto = document.getElementById('modalMotto');
  const modalHours = document.getElementById('modalHours');
  const modalImg = document.getElementById('modalImg');

  if (modalName) modalName.textContent = data.name;
  if (modalRoleBadge) modalRoleBadge.textContent = data.roleBadge;
  if (modalSubject) modalSubject.textContent = data.subject;
  if (modalEdu) modalEdu.textContent = data.edu;
  if (modalMotto) modalMotto.textContent = `"${data.motto}"`;
  if (modalHours) modalHours.textContent = data.hours;
  if (modalImg) modalImg.src = data.img;

  const modal = document.getElementById('teacherModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
}

function closeTeacherModal() {
  const modal = document.getElementById('teacherModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }
}

function initTeacherModalEvents() {
  const teacherModal = document.getElementById('teacherModal');
  if (teacherModal) {
    teacherModal.addEventListener('click', (e) => {
      if (e.target === teacherModal) closeTeacherModal();
    });
  }
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeTeacherModal();
  });
}

/* 6. Academic Page Interactive Phase Switcher (Fase A, B, C) */
function switchPhase(phase) {
  const contentA = document.getElementById('contentFaseA');
  const contentB = document.getElementById('contentFaseB');
  const contentC = document.getElementById('contentFaseC');

  const btnA = document.getElementById('btnFaseA');
  const btnB = document.getElementById('btnFaseB');
  const btnC = document.getElementById('btnFaseC');

  if (!contentA || !contentB || !contentC) return;

  contentA.classList.add('hidden');
  contentB.classList.add('hidden');
  contentC.classList.add('hidden');

  const inactiveStyle = "px-5 py-2.5 rounded-xl font-label-lg text-label-lg font-bold transition-all text-on-surface-variant hover:text-primary flex items-center gap-2";
  const activeStyle = "px-5 py-2.5 rounded-xl font-label-lg text-label-lg font-bold transition-all bg-primary text-on-primary shadow-sm flex items-center gap-2";

  [btnA, btnB, btnC].forEach(b => {
    if (b) b.className = inactiveStyle;
  });

  if (phase === 'A' && btnA) {
    contentA.classList.remove('hidden');
    btnA.className = activeStyle;
  } else if (phase === 'B' && btnB) {
    contentB.classList.remove('hidden');
    btnB.className = activeStyle;
  } else if (phase === 'C' && btnC) {
    contentC.classList.remove('hidden');
    btnC.className = activeStyle;
  }
}

/* 7. Academic Page Calendar Semester Switcher */
function switchSemester(sem) {
  const sem1 = document.getElementById('contentSem1');
  const sem2 = document.getElementById('contentSem2');

  const btnSem1 = document.getElementById('btnSem1');
  const btnSem2 = document.getElementById('btnSem2');

  if (!sem1 || !sem2) return;

  const activeBtn = "px-6 py-2.5 rounded-xl font-label-lg text-label-lg font-bold bg-primary text-on-primary shadow-sm transition-all";
  const inactiveBtn = "px-6 py-2.5 rounded-xl font-label-lg text-label-lg font-bold bg-surface-container-high text-on-surface-variant hover:text-primary transition-all";

  if (sem === 1) {
    sem1.classList.remove('hidden');
    sem2.classList.add('hidden');
    if (btnSem1) btnSem1.className = activeBtn;
    if (btnSem2) btnSem2.className = inactiveBtn;
  } else {
    sem2.classList.remove('hidden');
    sem1.classList.add('hidden');
    if (btnSem2) btnSem2.className = activeBtn;
    if (btnSem1) btnSem1.className = inactiveBtn;
  }
}

/* 8. Kesiswaan Page Extracurricular Filter & Search */
let currentEkskulFilter = 'all';

function setEkskulFilter(category) {
  currentEkskulFilter = category;
  
  const btnAll = document.getElementById('filterEkskulAll');
  const btnWajib = document.getElementById('filterEkskulWajib');
  const btnSport = document.getElementById('filterEkskulSport');
  const btnSains = document.getElementById('filterEkskulSains');
  const btnAgama = document.getElementById('filterEkskulAgama');

  const inactiveStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-surface-container-high text-on-surface-variant hover:text-primary transition-all";
  const activeStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-primary text-on-primary transition-all";

  [btnAll, btnWajib, btnSport, btnSains, btnAgama].forEach(b => {
    if (b) b.className = inactiveStyle;
  });

  if (category === 'all' && btnAll) btnAll.className = activeStyle;
  if (category === 'wajib' && btnWajib) btnWajib.className = activeStyle;
  if (category === 'olahraga-seni' && btnSport) btnSport.className = activeStyle;
  if (category === 'sains-it' && btnSains) btnSains.className = activeStyle;
  if (category === 'agama' && btnAgama) btnAgama.className = activeStyle;

  filterEkskul();
}

function filterEkskul() {
  const searchInputEl = document.getElementById('ekskulSearchInput');
  const searchInput = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
  const cards = document.querySelectorAll('.ekskul-card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cat = card.getAttribute('data-category');
    const name = card.getAttribute('data-name') ? card.getAttribute('data-name').toLowerCase() : '';
    const desc = card.getAttribute('data-desc') ? card.getAttribute('data-desc').toLowerCase() : '';

    const matchCategory = (currentEkskulFilter === 'all' || cat === currentEkskulFilter);
    const matchSearch = (name.includes(searchInput) || desc.includes(searchInput));

    if (matchCategory && matchSearch) {
      card.classList.remove('hidden');
      card.classList.add('flex');
      visibleCount++;
    } else {
      card.classList.add('hidden');
      card.classList.remove('flex');
    }
  });

  const noMatchMessage = document.getElementById('noEkskulMessage');
  if (noMatchMessage) {
    if (visibleCount === 0) {
      noMatchMessage.classList.remove('hidden');
    } else {
      noMatchMessage.classList.add('hidden');
    }
  }
}

/* 9. Facilities Page Lab Filter & Search */
let currentLabFilter = 'all';

function setLabFilter(category) {
  currentLabFilter = category;
  
  const btnAll = document.getElementById('filterLabAll');
  const btnIT = document.getElementById('filterLabIT');
  const btnSains = document.getElementById('filterLabSains');
  const btnSeni = document.getElementById('filterLabSeni');

  const inactiveStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-surface-container-high text-on-surface-variant hover:text-primary transition-all";
  const activeStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-primary text-on-primary transition-all";

  [btnAll, btnIT, btnSains, btnSeni].forEach(b => {
    if (b) b.className = inactiveStyle;
  });

  if (category === 'all' && btnAll) btnAll.className = activeStyle;
  if (category === 'it' && btnIT) btnIT.className = activeStyle;
  if (category === 'sains' && btnSains) btnSains.className = activeStyle;
  if (category === 'seni' && btnSeni) btnSeni.className = activeStyle;

  filterLabs();
}

function filterLabs() {
  const searchInputEl = document.getElementById('labSearchInput');
  const searchInput = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
  const cards = document.querySelectorAll('.lab-card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cat = card.getAttribute('data-category');
    const name = card.getAttribute('data-name') ? card.getAttribute('data-name').toLowerCase() : '';
    const desc = card.getAttribute('data-desc') ? card.getAttribute('data-desc').toLowerCase() : '';

    const matchCategory = (currentLabFilter === 'all' || cat === currentLabFilter);
    const matchSearch = (name.includes(searchInput) || desc.includes(searchInput));

    if (matchCategory && matchSearch) {
      card.classList.remove('hidden');
      card.classList.add('flex');
      visibleCount++;
    } else {
      card.classList.add('hidden');
      card.classList.remove('flex');
    }
  });

  const noMatchMessage = document.getElementById('noLabMessage');
  if (noMatchMessage) {
    if (visibleCount === 0) {
      noMatchMessage.classList.remove('hidden');
    } else {
      noMatchMessage.classList.add('hidden');
    }
  }
}

/* 10. Achievements Page Filter & Search System */
let currentAchievementFilter = 'all';

function setAchievementFilter(category) {
  currentAchievementFilter = category;
  
  const btnAll = document.getElementById('filterAchievementAll');
  const btnInter = document.getElementById('filterAchievementInter');
  const btnNasional = document.getElementById('filterAchievementNasional');
  const btnDaerah = document.getElementById('filterAchievementDaerah');
  const btnSTEM = document.getElementById('filterAchievementSTEM');

  const inactiveStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-surface-container-high text-on-surface-variant hover:text-primary transition-all cursor-pointer";
  const activeStyle = "px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-primary text-on-primary transition-all cursor-pointer shadow-sm";

  [btnAll, btnInter, btnNasional, btnDaerah, btnSTEM].forEach(b => {
    if (b) b.className = inactiveStyle;
  });

  if (category === 'all' && btnAll) btnAll.className = activeStyle;
  if (category === 'internasional' && btnInter) btnInter.className = activeStyle;
  if (category === 'nasional' && btnNasional) btnNasional.className = activeStyle;
  if (category === 'daerah' && btnDaerah) btnDaerah.className = activeStyle;
  if (category === 'stem' && btnSTEM) btnSTEM.className = activeStyle;

  filterAchievements();
}

function filterAchievements() {
  const searchInputEl = document.getElementById('achievementSearchInput');
  const searchInput = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
  const cards = document.querySelectorAll('.achievement-card');
  let visibleCount = 0;

  cards.forEach(card => {
    const cat = card.getAttribute('data-category');
    const title = card.getAttribute('data-title') ? card.getAttribute('data-title').toLowerCase() : '';
    const winner = card.getAttribute('data-winner') ? card.getAttribute('data-winner').toLowerCase() : '';
    const event = card.getAttribute('data-event') ? card.getAttribute('data-event').toLowerCase() : '';

    const matchCategory = (currentAchievementFilter === 'all' || cat === currentAchievementFilter);
    const matchSearch = (title.includes(searchInput) || winner.includes(searchInput) || event.includes(searchInput));

    if (matchCategory && matchSearch) {
      card.classList.remove('hidden');
      card.classList.add('flex');
      visibleCount++;
    } else {
      card.classList.add('hidden');
      card.classList.remove('flex');
    }
  });

  const noMatchMessage = document.getElementById('noAchievementMessage');
  if (noMatchMessage) {
    if (visibleCount === 0) {
      noMatchMessage.classList.remove('hidden');
    } else {
      noMatchMessage.classList.add('hidden');
    }
  }
}

/* 11. Gallery Page Filter, Search & Lightbox System */
let currentGalleryCategory = 'all';
let currentGalleryType = 'all';
let currentLightboxIndex = 0;
let visibleGalleryCards = [];

function setGalleryCategory(cat) {
  currentGalleryCategory = cat;

  const buttons = document.querySelectorAll('[data-gallery-filter]');
  buttons.forEach(btn => {
    const filterVal = btn.getAttribute('data-gallery-filter');
    if (filterVal === cat) {
      btn.className = "gallery-filter-btn px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-primary text-on-primary shadow-sm transition-all";
    } else {
      btn.className = "gallery-filter-btn px-4 py-2 rounded-xl font-label-md text-label-md font-bold bg-surface-container-high text-on-surface-variant hover:text-primary transition-all";
    }
  });

  filterGallery();
}

function setGalleryType(type) {
  currentGalleryType = type;

  const typeButtons = document.querySelectorAll('[data-gallery-type]');
  typeButtons.forEach(btn => {
    const typeVal = btn.getAttribute('data-gallery-type');
    if (typeVal === type) {
      btn.className = "gallery-type-btn px-3.5 py-1.5 rounded-lg font-label-sm text-label-sm font-bold bg-primary text-on-primary transition-all";
    } else {
      btn.className = "gallery-type-btn px-3.5 py-1.5 rounded-lg font-label-sm text-label-sm font-semibold bg-surface-container text-on-surface-variant hover:text-primary transition-all";
    }
  });

  filterGallery();
}

function filterGallery() {
  const searchInputEl = document.getElementById('gallerySearchInput');
  const searchInput = searchInputEl ? searchInputEl.value.toLowerCase().trim() : '';
  const cards = document.querySelectorAll('.gallery-item-card');
  visibleGalleryCards = [];

  cards.forEach(card => {
    const cat = card.getAttribute('data-category') || '';
    const type = card.getAttribute('data-type') || '';
    const title = (card.getAttribute('data-title') || '').toLowerCase();
    const desc = (card.getAttribute('data-desc') || '').toLowerCase();
    const tags = (card.getAttribute('data-tags') || '').toLowerCase();

    const matchCategory = (currentGalleryCategory === 'all' || cat === currentGalleryCategory);
    const matchType = (currentGalleryType === 'all' || type === currentGalleryType);
    const matchSearch = (!searchInput || title.includes(searchInput) || desc.includes(searchInput) || tags.includes(searchInput));

    if (matchCategory && matchType && matchSearch) {
      card.classList.remove('hidden');
      card.classList.add('flex');
      visibleGalleryCards.push(card);
    } else {
      card.classList.add('hidden');
      card.classList.remove('flex');
    }
  });

  // Update counter
  const countEl = document.getElementById('galleryCountIndicator');
  if (countEl) {
    countEl.textContent = `Menampilkan ${visibleGalleryCards.length} dokumentasi kegiatan`;
  }

  // No match banner
  const noMatchMessage = document.getElementById('noGalleryMessage');
  if (noMatchMessage) {
    if (visibleGalleryCards.length === 0) {
      noMatchMessage.classList.remove('hidden');
      noMatchMessage.classList.add('flex');
    } else {
      noMatchMessage.classList.add('hidden');
      noMatchMessage.classList.remove('flex');
    }
  }
}

function resetGalleryFilter() {
  const searchInputEl = document.getElementById('gallerySearchInput');
  if (searchInputEl) searchInputEl.value = '';
  setGalleryCategory('all');
  setGalleryType('all');
}

function openGalleryLightboxByCard(cardElement) {
  const idx = visibleGalleryCards.indexOf(cardElement);
  if (idx !== -1) {
    openGalleryLightbox(idx);
  } else {
    const imgSrc = cardElement.getAttribute('data-img') || cardElement.querySelector('img')?.src;
    const title = cardElement.getAttribute('data-title') || '';
    const desc = cardElement.getAttribute('data-desc') || '';
    const cat = cardElement.getAttribute('data-badge') || cardElement.getAttribute('data-category') || '';
    const date = cardElement.getAttribute('data-date') || '';
    const type = cardElement.getAttribute('data-type') || 'foto';
    const videoUrl = cardElement.getAttribute('data-video-url') || '';

    renderLightboxContent({ imgSrc, title, desc, cat, date, type, videoUrl, current: 1, total: 1 });
  }
}

function openGalleryLightbox(index) {
  if (visibleGalleryCards.length === 0) return;
  if (index < 0) index = visibleGalleryCards.length - 1;
  if (index >= visibleGalleryCards.length) index = 0;

  currentLightboxIndex = index;
  const card = visibleGalleryCards[currentLightboxIndex];
  if (!card) return;

  const imgSrc = card.getAttribute('data-img') || card.querySelector('img')?.src;
  const title = card.getAttribute('data-title') || '';
  const desc = card.getAttribute('data-desc') || '';
  const cat = card.getAttribute('data-badge') || card.getAttribute('data-category') || '';
  const date = card.getAttribute('data-date') || '';
  const type = card.getAttribute('data-type') || 'foto';
  const videoUrl = card.getAttribute('data-video-url') || '';

  renderLightboxContent({
    imgSrc,
    title,
    desc,
    cat,
    date,
    type,
    videoUrl,
    current: currentLightboxIndex + 1,
    total: visibleGalleryCards.length
  });
}

function renderLightboxContent(data) {
  const modal = document.getElementById('galleryLightboxModal');
  if (!modal) return;

  const imgEl = document.getElementById('lightboxImg');
  const videoContainer = document.getElementById('lightboxVideoContainer');
  const videoIframe = document.getElementById('lightboxVideoIframe');
  const titleEl = document.getElementById('lightboxTitle');
  const descEl = document.getElementById('lightboxDesc');
  const badgeEl = document.getElementById('lightboxBadge');
  const dateEl = document.getElementById('lightboxDate');
  const counterEl = document.getElementById('lightboxCounter');

  if (titleEl) titleEl.textContent = data.title;
  if (descEl) descEl.textContent = data.desc;
  if (badgeEl) badgeEl.textContent = data.cat;
  if (dateEl) dateEl.textContent = data.date;
  if (counterEl) counterEl.textContent = `${data.current} dari ${data.total}`;

  if (data.type === 'video' && data.videoUrl) {
    if (imgEl) imgEl.classList.add('hidden');
    if (videoContainer) {
      videoContainer.classList.remove('hidden');
      if (videoIframe) videoIframe.src = data.videoUrl;
    }
  } else {
    if (videoContainer) {
      videoContainer.classList.add('hidden');
      if (videoIframe) videoIframe.src = '';
    }
    if (imgEl) {
      imgEl.classList.remove('hidden');
      imgEl.src = data.imgSrc;
      imgEl.alt = data.title;
    }
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.body.style.overflow = 'hidden';
}

function closeGalleryLightbox() {
  const modal = document.getElementById('galleryLightboxModal');
  if (!modal) return;

  modal.classList.add('hidden');
  modal.classList.remove('flex');
  document.body.style.overflow = 'auto';

  const videoIframe = document.getElementById('lightboxVideoIframe');
  if (videoIframe) videoIframe.src = '';
}

function navigateGallery(direction) {
  if (visibleGalleryCards.length <= 1) return;
  openGalleryLightbox(currentLightboxIndex + direction);
}

function initGalleryEvents() {
  const modal = document.getElementById('galleryLightboxModal');
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal || e.target.id === 'lightboxBackdrop') {
        closeGalleryLightbox();
      }
    });
  }

  document.addEventListener('keydown', (e) => {
    const lightboxModal = document.getElementById('galleryLightboxModal');
    if (lightboxModal && !lightboxModal.classList.contains('hidden')) {
      if (e.key === 'Escape') closeGalleryLightbox();
      if (e.key === 'ArrowLeft') navigateGallery(-1);
      if (e.key === 'ArrowRight') navigateGallery(1);
    }
  });

  if (document.querySelectorAll('.gallery-item-card').length > 0) {
    filterGallery();
  }
}

/* 12. PPDB Interactive Multi-Step Form & Fee Calculator */
let currentPpdbStep = 1;

function switchPpdbStep(step) {
  const step1 = document.getElementById('ppdbStep1');
  const step2 = document.getElementById('ppdbStep2');
  const step3 = document.getElementById('ppdbStep3');

  const indicator1 = document.getElementById('stepIndicator1');
  const indicator2 = document.getElementById('stepIndicator2');
  const indicator3 = document.getElementById('stepIndicator3');

  if (!step1 || !step2 || !step3) return;

  if (step === 2 && currentPpdbStep === 1) {
    const studentName = document.getElementById('studentName');
    const studentBirth = document.getElementById('studentBirthDate');
    if (!studentName || !studentName.value.trim()) {
      alert('Mohon isi nama lengkap calon peserta didik terlebih dahulu.');
      studentName?.focus();
      return;
    }
    if (!studentBirth || !studentBirth.value) {
      alert('Mohon pilih tanggal lahir calon siswa.');
      studentBirth?.focus();
      return;
    }
  }

  if (step === 3 && currentPpdbStep === 2) {
    const parentName = document.getElementById('parentName');
    const parentPhone = document.getElementById('parentPhone');
    if (!parentName || !parentName.value.trim()) {
      alert('Mohon lengkapi nama orang tua / wali.');
      parentName?.focus();
      return;
    }
    if (!parentPhone || !parentPhone.value.trim()) {
      alert('Mohon isi nomor WhatsApp aktif untuk pengiriman bukti verifikasi pendaftaran.');
      parentPhone?.focus();
      return;
    }

    const reviewName = document.getElementById('reviewStudentName');
    const reviewTrack = document.getElementById('reviewTrack');
    const reviewParent = document.getElementById('reviewParent');
    const reviewPhone = document.getElementById('reviewPhone');

    const nameInput = document.getElementById('studentName');
    const trackInput = document.getElementById('admissionTrack');
    const parentInput = document.getElementById('parentName');
    const phoneInput = document.getElementById('parentPhone');

    if (reviewName && nameInput) reviewName.textContent = nameInput.value;
    if (reviewTrack && trackInput) reviewTrack.textContent = trackInput.options[trackInput.selectedIndex].text;
    if (reviewParent && parentInput) reviewParent.textContent = parentInput.value;
    if (reviewPhone && phoneInput) reviewPhone.textContent = phoneInput.value;
  }

  currentPpdbStep = step;

  step1.classList.add('hidden');
  step2.classList.add('hidden');
  step3.classList.add('hidden');

  const activeIndicator = "flex items-center gap-2 px-4 py-2.5 rounded-xl bg-primary text-on-primary font-bold shadow-sm transition-all";
  const inactiveIndicator = "flex items-center gap-2 px-4 py-2.5 rounded-xl bg-surface-container text-on-surface-variant font-semibold transition-all";

  [indicator1, indicator2, indicator3].forEach(ind => {
    if (ind) ind.className = inactiveIndicator;
  });

  if (step === 1) {
    step1.classList.remove('hidden');
    if (indicator1) indicator1.className = activeIndicator;
  } else if (step === 2) {
    step2.classList.remove('hidden');
    if (indicator2) indicator2.className = activeIndicator;
  } else if (step === 3) {
    step3.classList.remove('hidden');
    if (indicator3) indicator3.className = activeIndicator;
  }

  const formTop = document.getElementById('formulir-ppdb');
  if (formTop) formTop.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function handlePpdbFormSubmit(e) {
  if (e) e.preventDefault();

  const studentNameInput = document.getElementById('studentName');
  const parentPhoneInput = document.getElementById('parentPhone');
  const trackInput = document.getElementById('ppdbTrack') || document.getElementById('admissionTrack');

  const studentName = studentNameInput ? studentNameInput.value.trim() : 'Ananda';
  const parentPhone = parentPhoneInput ? parentPhoneInput.value.trim() : '-';
  const trackName = (trackInput && trackInput.selectedIndex >= 0) ? trackInput.options[trackInput.selectedIndex].text : 'Jalur Reguler';

  const randomNum = Math.floor(1000 + Math.random() * 9000);
  const regId = `PPDB-SD-${randomNum}`;

  const modalRegId = document.getElementById('modalRegId');
  const modalStudentName = document.getElementById('modalStudentName');
  const modalTrack = document.getElementById('modalTrack');
  const modalWaLink = document.getElementById('modalWaConfirmationBtn');

  if (modalRegId) modalRegId.textContent = regId;
  if (modalStudentName) modalStudentName.textContent = studentName;
  if (modalTrack) modalTrack.textContent = trackName;

  if (modalWaLink) {
    const message = encodeURIComponent(`Halo Panitia PPDB SDN Cikereteg 01, saya ingin konfirmasi pendaftaran online calon siswa baru atas nama ${studentName} dengan Nomor Pendaftaran: ${regId}.`);
    modalWaLink.href = `https://wa.me/6281234567890?text=${message}`;
  }

  const modal = document.getElementById('ppdbSuccessModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
}

function handlePpdbSubmit(e) {
  handlePpdbFormSubmit(e);
}

function closePpdbSuccessModal() {
  const modal = document.getElementById('ppdbSuccessModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }

  const form = document.getElementById('ppdbRegistrationForm');
  if (form) form.reset();
  switchPpdbStep(1);
}

function initPpdbEvents() {
  const modal = document.getElementById('ppdbSuccessModal');
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal || e.target.id === 'ppdbModalBackdrop') {
        closePpdbSuccessModal();
      }
    });
  }

  document.addEventListener('keydown', (e) => {
    const successModal = document.getElementById('ppdbSuccessModal');
    if (successModal && !successModal.classList.contains('hidden')) {
      if (e.key === 'Escape') closePpdbSuccessModal();
    }
  });
}

/* 13. Contact & School Visit Handlers */
function handleContactFormSubmit(event) {
  event.preventDefault();

  const nameInput = document.getElementById('contactName');
  const phoneInput = document.getElementById('contactPhone');
  const emailInput = document.getElementById('contactEmail');
  const categoryInput = document.getElementById('contactCategory');
  const subjectInput = document.getElementById('contactSubject');
  const messageInput = document.getElementById('contactMessage');
  const channelRadio = document.querySelector('input[name="contactChannel"]:checked');

  const senderName = nameInput ? nameInput.value.trim() : 'Orang Tua / Wali';
  const categoryVal = categoryInput ? categoryInput.value : 'Informasi Umum';
  const subjectVal = subjectInput ? subjectInput.value.trim() : 'Pertanyaan Layanan';
  const phoneVal = phoneInput ? phoneInput.value.trim() : '';
  const channelVal = channelRadio ? channelRadio.value : 'WhatsApp';

  // Generate unique tracking ticket
  const randomNum = Math.floor(1000 + Math.random() * 9000);
  const ticketId = `PESAN-SD-${randomNum}`;

  const modalTicketId = document.getElementById('contactModalTicketId');
  const modalSender = document.getElementById('contactModalSender');
  const modalCategory = document.getElementById('contactModalCategory');
  const modalSubject = document.getElementById('contactModalSubject');
  const modalChannel = document.getElementById('contactModalChannel');
  const modalWaBtn = document.getElementById('contactModalWaBtn');

  if (modalTicketId) modalTicketId.textContent = ticketId;
  if (modalSender) modalSender.textContent = senderName;
  if (modalCategory) modalCategory.textContent = categoryVal;
  if (modalSubject) modalSubject.textContent = subjectVal;
  if (modalChannel) modalChannel.textContent = channelVal;

  if (modalWaBtn) {
    const textMsg = encodeURIComponent(`Halo SDN Cikereteg 01, saya ingin konfirmasi pengiriman pesan online:\nNama: ${senderName}\nKategori: ${categoryVal}\nNomor Tiket: ${ticketId}\nSubjek: ${subjectVal}`);
    modalWaBtn.href = `https://wa.me/6281234567890?text=${textMsg}`;
  }

  const modal = document.getElementById('contactSuccessModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
}

function closeContactSuccessModal() {
  const modal = document.getElementById('contactSuccessModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }

  const form = document.getElementById('contactForm');
  if (form) form.reset();
}

function copyContactTicket() {
  const ticketEl = document.getElementById('contactModalTicketId');
  if (!ticketEl) return;
  const text = ticketEl.textContent;
  navigator.clipboard.writeText(text).then(() => {
    const copyBtnText = document.getElementById('copyTicketBtnText');
    if (copyBtnText) {
      const original = copyBtnText.textContent;
      copyBtnText.textContent = 'Tersalin!';
      setTimeout(() => {
        copyBtnText.textContent = original;
      }, 2000);
    }
  }).catch(() => {
    alert(`Nomor Tiket Anda: ${text}`);
  });
}

function handleSchoolTourSubmit(event) {
  event.preventDefault();

  const parentNameInput = document.getElementById('tourParentName');
  const phoneInput = document.getElementById('tourPhone');
  const dateInput = document.getElementById('tourDate');
  const sessionInput = document.getElementById('tourSession');
  const attendeesInput = document.getElementById('tourAttendees');
  const gradeInput = document.getElementById('tourGradeInterest');

  const parentName = parentNameInput ? parentNameInput.value.trim() : 'Orang Tua';
  const visitDate = dateInput && dateInput.value ? dateInput.value : 'Sesuai Jadwal';
  const visitSession = sessionInput ? sessionInput.value : 'Sesi Pagi (08.00 - 09.30 WIB)';
  const attendees = attendeesInput ? attendeesInput.value : '2 Orang';
  const grade = gradeInput ? gradeInput.value : 'Kelas 1 SD';

  const randomNum = Math.floor(1000 + Math.random() * 9000);
  const bookingCode = `KUNJUNGAN-SD-${randomNum}`;

  const modalCode = document.getElementById('tourModalCode');
  const modalParent = document.getElementById('tourModalParent');
  const modalDate = document.getElementById('tourModalDate');
  const modalSession = document.getElementById('tourModalSession');
  const modalAttendees = document.getElementById('tourModalAttendees');
  const modalGrade = document.getElementById('tourModalGrade');
  const modalWaBtn = document.getElementById('tourModalWaBtn');

  if (modalCode) modalCode.textContent = bookingCode;
  if (modalParent) modalParent.textContent = parentName;
  if (modalDate) modalDate.textContent = visitDate;
  if (modalSession) modalSession.textContent = visitSession;
  if (modalAttendees) modalAttendees.textContent = attendees;
  if (modalGrade) modalGrade.textContent = grade;

  if (modalWaBtn) {
    const textMsg = encodeURIComponent(`Halo SDN Cikereteg 01, saya telah membuat janji kunjungan sekolah:\nKode Booking: ${bookingCode}\nNama: ${parentName}\nTanggal: ${visitDate}\nSesi: ${visitSession}\nJumlah: ${attendees}`);
    modalWaBtn.href = `https://wa.me/6281234567890?text=${textMsg}`;
  }

  const modal = document.getElementById('tourSuccessModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
}

function closeTourSuccessModal() {
  const modal = document.getElementById('tourSuccessModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }

  const form = document.getElementById('schoolTourForm');
  if (form) form.reset();
}

function initContactEvents() {
  const contactModal = document.getElementById('contactSuccessModal');
  if (contactModal) {
    contactModal.addEventListener('click', (e) => {
      if (e.target === contactModal || e.target.id === 'contactModalBackdrop') {
        closeContactSuccessModal();
      }
    });
  }

  const tourModal = document.getElementById('tourSuccessModal');
  if (tourModal) {
    tourModal.addEventListener('click', (e) => {
      if (e.target === tourModal || e.target.id === 'tourModalBackdrop') {
        closeTourSuccessModal();
      }
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const contactModal = document.getElementById('contactSuccessModal');
      if (contactModal && !contactModal.classList.contains('hidden')) {
        closeContactSuccessModal();
      }
      const tourModal = document.getElementById('tourSuccessModal');
      if (tourModal && !tourModal.classList.contains('hidden')) {
        closeTourSuccessModal();
      }
    }
  });
}
