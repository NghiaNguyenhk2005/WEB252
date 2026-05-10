<?php require_once 'views/client/components/header.php'; ?>

<section class="py-5 bg-primary bg-opacity-10">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Câu hỏi thường gặp</h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;" data-aos="fade-up" data-aos-delay="100">
            Giải đáp những thắc mắc phổ biến nhất về dịch vụ và nền tảng của TechSaaS.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden border" id="faqAccordion">
                    <?php if (isset($faqs) && is_object($faqs) && $faqs->num_rows > 0): ?>
                        <?php $i = 0; while($faq = $faqs->fetch_assoc()): ?>
                            <div class="accordion-item border-bottom">
                                <h2 class="accordion-header">
                                    <button class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?> fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?= $faq['id'] ?>">
                                        <?= htmlspecialchars($faq['question']) ?>
                                    </button>
                                </h2>
                                <div id="faq-<?= $faq['id'] ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body py-4 text-muted lead fs-6">
                                        <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; endwhile; ?>
                    <?php else: ?>
                        <div class="p-5 text-center text-muted">Chưa có câu hỏi nào được cập nhật.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ASK A QUESTION FORM -->
<section class="py-5 bg-white border-top">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-chat-dots fs-3"></i>
                </div>
                <h2 class="fw-bold mb-3">Bạn vẫn còn thắc mắc?</h2>
                <p class="text-muted mb-5">Hãy gửi câu hỏi cho chúng tôi, đội ngũ hỗ trợ sẽ trả lời bạn sớm nhất có thể.</p>
                
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success border-0 rounded-4 p-3 mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> Câu hỏi của bạn đã được gửi thành công!
                    </div>
                <?php endif; ?>

                <form action="index.php?url=faqs/submit" method="POST" class="text-start">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Câu hỏi của bạn</label>
                        <textarea name="question" class="form-control rounded-4 p-3" rows="4" placeholder="Nhập nội dung câu hỏi tại đây..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-gradient btn-lg w-100 rounded-pill shadow">Gửi câu hỏi ngay</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once 'views/client/components/footer.php'; ?>