<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;

class ApostilleBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if article already exists
        $existing = Blog::where('slug', 'like', 'what-is-apostille-complete-guide%')->first();
        if ($existing) {
            $this->command->info('Apostille blog article already exists. Skipping.');
            return;
        }

        // Get admin user
        $admin = User::where('user_type', 'admin')->first();
        if (!$admin) {
            $this->command->error('No admin user found. Please create one first.');
            return;
        }

        // Get or create "Immigration & Visas" category
        $category = BlogCategory::where('slug', 'immigration-visas')->first();
        if (!$category) {
            $category = BlogCategory::create([
                'name' => 'Immigration & Visas',
                'slug' => 'immigration-visas',
                'description' => 'Visa application processes and immigration guidance',
                'is_active' => true,
                'sort_order' => 4,
            ]);
        }

        // Generate featured image
        $imagePath = $this->createFeaturedImage();

        // Create the blog article
        Blog::create([
            'title' => 'What Is an Apostille? Complete Guide to Document Authentication',
            'slug' => 'what-is-apostille-complete-guide-to-document-authentication',
            'blog_category_id' => $category->id,
            'user_id' => $admin->id,
            'excerpt' => 'An apostille is an official certification issued under the Hague Convention that authenticates documents for legal use in over 150 member countries. Learn what apostille is, which documents need one, and how PlaceMeNet helps.',
            'content' => $this->getArticleContent(),
            'featured_image' => $imagePath,
            'featured_image_alt' => 'Official apostille certificate and document authentication guide with international flags',
            'meta_title' => 'What Is an Apostille? Document Authentication Guide',
            'meta_description' => 'Learn what an apostille is, how it works under the Hague Convention, which documents need one, and how PlaceMeNet helps with apostille for certificates.',
            'meta_keywords' => 'apostille, what is an apostille, hague convention, document authentication, apostille certificate, FCDO apostille, document legalisation, apostille service, police certificate apostille',
            'status' => 'approved',
            'published_at' => now(),
            'is_featured' => true,
            'featured_order' => 1,
        ]);

        $this->command->info('Apostille blog article created and published successfully!');
    }

    /**
     * Generate a featured image using PHP GD.
     */
    private function createFeaturedImage(): string
    {
        $width = 1920;
        $height = 1080;
        $relativePath = 'blogs/featured/2026/02/what-is-apostille.jpg';
        $fullDir = storage_path('app/public/blogs/featured/2026/02');
        $fullPath = storage_path('app/public/' . $relativePath);

        // Create directory if it doesn't exist
        if (!is_dir($fullDir)) {
            mkdir($fullDir, 0755, true);
        }

        // Create image canvas
        $img = imagecreatetruecolor($width, $height);

        // Deep indigo/blue gradient background
        $colorTop = imagecolorallocate($img, 30, 27, 75);    // #1E1B4B - deep indigo
        $colorMid = imagecolorallocate($img, 49, 46, 129);   // #312E81 - indigo
        $colorBot = imagecolorallocate($img, 30, 64, 175);   // #1E40AF - blue

        // Draw gradient
        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            if ($ratio < 0.5) {
                $r2 = $ratio * 2;
                $r = (int)(30 + (49 - 30) * $r2);
                $g = (int)(27 + (46 - 27) * $r2);
                $b = (int)(75 + (129 - 75) * $r2);
            } else {
                $r2 = ($ratio - 0.5) * 2;
                $r = (int)(49 + (30 - 49) * $r2);
                $g = (int)(46 + (64 - 46) * $r2);
                $b = (int)(129 + (175 - 129) * $r2);
            }
            $color = imagecolorallocate($img, $r, $g, $b);
            imageline($img, 0, $y, $width - 1, $y, $color);
        }

        // Add subtle decorative elements - geometric shapes
        $overlay = imagecolorallocatealpha($img, 255, 255, 255, 115); // ~10% white
        imagefilledellipse($img, 1600, 200, 400, 400, $overlay);
        imagefilledellipse($img, 200, 900, 300, 300, $overlay);

        // Decorative lines
        $lineColor = imagecolorallocatealpha($img, 255, 255, 255, 110);
        imagesetthickness($img, 2);
        imageline($img, 100, 480, 1820, 480, $lineColor);
        imageline($img, 100, 700, 1820, 700, $lineColor);

        // Decorative accent bar at top
        $accent = imagecolorallocate($img, 99, 102, 241); // #6366F1 indigo-500
        imagefilledrectangle($img, 0, 0, $width, 8, $accent);

        // Font path
        $fontBold = '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf';
        $fontRegular = '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf';

        $white = imagecolorallocate($img, 255, 255, 255);
        $lightBlue = imagecolorallocate($img, 165, 180, 252); // #A5B4FC indigo-300
        $softWhite = imagecolorallocate($img, 224, 231, 255); // #E0E7FF indigo-100

        // Small label above title
        imagettftext($img, 22, 0, 100, 420, $lightBlue, $fontRegular, 'COMPLETE GUIDE');

        // Title text
        imagettftext($img, 72, 0, 100, 570, $white, $fontBold, 'What Is an Apostille?');

        // Subtitle
        imagettftext($img, 36, 0, 100, 650, $softWhite, $fontRegular, 'Document Authentication Under the Hague Convention');

        // Bottom branding bar
        $brandBg = imagecolorallocatealpha($img, 0, 0, 0, 80);
        imagefilledrectangle($img, 0, $height - 100, $width, $height, $brandBg);

        // PlaceMeNet branding
        imagettftext($img, 28, 0, 100, $height - 38, $white, $fontBold, 'PlaceMeNet');
        imagettftext($img, 20, 0, 340, $height - 38, $lightBlue, $fontRegular, 'placemenet.com');

        // Right side info
        imagettftext($img, 20, 0, 1400, $height - 38, $softWhite, $fontRegular, 'Hague Convention  |  150+ Countries');

        // Small document icon (simplified stamp representation)
        $stampColor = imagecolorallocatealpha($img, 99, 102, 241, 90);
        imagefilledrectangle($img, 1500, 180, 1700, 380, $stampColor);
        $stampBorder = imagecolorallocatealpha($img, 165, 180, 252, 80);
        imagerectangle($img, 1500, 180, 1700, 380, $stampBorder);
        imagettftext($img, 18, 0, 1530, 270, $lightBlue, $fontBold, 'APOSTILLE');
        imagettftext($img, 14, 0, 1535, 300, $softWhite, $fontRegular, 'CONVENTION');
        imagettftext($img, 14, 0, 1548, 325, $softWhite, $fontRegular, 'DE LA HAYE');

        // Output as JPEG
        imagejpeg($img, $fullPath, 90);
        imagedestroy($img);

        return $relativePath;
    }

    /**
     * Get the full article HTML content.
     */
    private function getArticleContent(): string
    {
        return <<<'HTML'
<p><strong>An apostille is an official certification, issued under the 1961 Hague Convention, that authenticates the origin of a public document so it is recognised as legally valid in any of the 150+ member countries.</strong> Instead of going through lengthy embassy legalisation, an apostille provides a single, universally accepted stamp of authenticity.</p>

<h2>What Does an Apostille Look Like?</h2>

<p>An apostille is a standardised certificate, usually a single-page document attached to (or stamped on the back of) the original document. It follows a strict format defined by the Hague Convention and always contains <strong>ten numbered fields</strong>:</p>

<ol>
<li><strong>Country</strong> — the country where the document was issued</li>
<li><strong>Signatory</strong> — the person who signed the document</li>
<li><strong>Capacity</strong> — the role or title of the signatory</li>
<li><strong>Seal/stamp details</strong> — description of any seal on the document</li>
<li><strong>Location of certification</strong> — city where the apostille was issued</li>
<li><strong>Date of certification</strong> — when the apostille was issued</li>
<li><strong>Issuing authority</strong> — the body that granted the apostille</li>
<li><strong>Certificate number</strong> — a unique reference number for verification</li>
<li><strong>Seal of the authority</strong> — official stamp of the issuing body</li>
<li><strong>Signature of the authority</strong> — authorised signature</li>
</ol>

<p>It is important to understand that an apostille <strong>certifies the origin of the document — not its content</strong>. It confirms the signature, seal, and capacity of the person or authority that issued the original document.</p>

<h2>Why Do You Need an Apostille?</h2>

<p>Whenever you use official documents across international borders, the receiving country needs assurance that your documents are genuine. Common situations where you need an apostille include:</p>

<ul>
<li><strong>Employment abroad</strong> — employers may require apostilled criminal record checks before hiring foreign workers</li>
<li><strong>Immigration and visa applications</strong> — many countries require apostilled birth certificates, police clearances, and educational credentials as part of the visa process</li>
<li><strong>Legal proceedings</strong> — court orders, powers of attorney, and other legal documents used in foreign jurisdictions typically need apostille authentication</li>
<li><strong>Academic enrolment</strong> — universities abroad often require apostilled copies of degrees, diplomas, and transcripts</li>
<li><strong>Marriage abroad</strong> — getting married in another country frequently requires an apostilled birth certificate and decree absolute (if previously divorced)</li>
</ul>

<p>If you are applying for a <a href="/uk-police-certificate">UK Police Character Certificate</a>, <a href="/greece-penal-record">Greece Penal Record Certificate</a>, or <a href="/portugal-criminal-record">Portugal Criminal Record Certificate</a> for use in another country, there is a strong chance you will need an apostille to go with it.</p>

<h2>How Does the Hague Apostille Convention Work?</h2>

<p>The <strong>Hague Convention of 5 October 1961</strong> (formally known as the "Convention Abolishing the Requirement of Legalisation for Foreign Public Documents") was created to simplify the process of authenticating documents for international use.</p>

<p>Before the Convention, getting a document recognised abroad required a cumbersome chain of legalisation: the document had to be verified by multiple government departments, then by the foreign ministry, and finally by the embassy or consulate of the destination country. This process could take weeks or even months.</p>

<p>The apostille system replaced this chain with a <strong>single certification step</strong>. A designated authority in the country where the document was issued attaches an apostille, and the document is then automatically accepted in all other member countries — no further verification needed.</p>

<p>Today, <strong>over 150 countries</strong> are members of the Hague Apostille Convention, including all EU member states, the United Kingdom, the United States, Australia, Japan, and many others.</p>

<h3>Apostille vs Embassy Legalisation</h3>

<p>If the destination country is <strong>not</strong> a member of the Hague Convention (for example, Canada or the UAE), an apostille will not be accepted. In that case, you must go through the traditional <strong>embassy legalisation</strong> process, which involves authentication by the Foreign, Commonwealth & Development Office (FCDO) followed by legalisation at the relevant embassy.</p>

<h2>Which Documents Can Be Apostilled?</h2>

<p>Almost any public document can be apostilled. Here are the most common categories:</p>

<h3>Personal Documents</h3>
<ul>
<li>Birth certificates</li>
<li>Marriage certificates</li>
<li>Death certificates</li>
<li>Deed poll (name change) documents</li>
<li>Divorce decrees (decree absolute)</li>
</ul>

<h3>Legal Documents</h3>
<ul>
<li>Court orders and judgements</li>
<li>Powers of attorney</li>
<li>Affidavits and statutory declarations</li>
<li>Notarised documents</li>
</ul>

<h3>Educational Documents</h3>
<ul>
<li>University degrees and diplomas</li>
<li>Academic transcripts</li>
<li>Professional qualification certificates</li>
<li>School leaving certificates</li>
</ul>

<h3>Criminal Record Certificates</h3>

<p>Criminal record checks are among the most frequently apostilled documents. Whether you need a <a href="/uk-police-certificate">UK Police Character Certificate (ACRO)</a>, a <a href="/greece-penal-record">Greece Penal Record Certificate</a>, or a <a href="/portugal-criminal-record">Portugal Criminal Record Certificate</a>, you will likely need an apostille if the certificate is intended for use in another country.</p>

<h3>Business Documents</h3>
<ul>
<li>Company registration certificates</li>
<li>Articles of association</li>
<li>Board resolutions</li>
<li>Certificates of good standing</li>
</ul>

<h2>How to Get an Apostille: Step-by-Step</h2>

<p>The exact process varies by country, but in the United Kingdom the process is as follows:</p>

<ol>
<li><strong>Obtain your original document</strong> — ensure you have the original or a certified copy issued by the relevant authority. Photocopies are not accepted.</li>
<li><strong>Check the document is eligible</strong> — the document must be a UK-issued public document bearing an official signature, seal, or stamp.</li>
<li><strong>Submit to the FCDO</strong> — send your document to the Foreign, Commonwealth & Development Office (FCDO) Legalisation Office, either by post or through a professional service.</li>
<li><strong>FCDO verifies the document</strong> — the Legalisation Office confirms the signature and seal on your document are genuine.</li>
<li><strong>Apostille is attached</strong> — once verified, the FCDO attaches the apostille certificate to your document.</li>
<li><strong>Document is returned</strong> — the apostilled document is sent back to you, ready for use abroad.</li>
</ol>

<p>Using a professional service like PlaceMeNet can streamline this process significantly, especially when combined with a certificate application.</p>

<h2>How Much Does an Apostille Cost?</h2>

<p>Costs vary depending on how you apply:</p>

<div style="overflow-x:auto;">
<table style="width:100%; border-collapse:collapse; margin:1.5em 0;">
<thead>
<tr style="background-color:#312E81; color:#fff;">
<th style="padding:12px 16px; text-align:left; border:1px solid #4338CA;">Service</th>
<th style="padding:12px 16px; text-align:left; border:1px solid #4338CA;">Cost</th>
<th style="padding:12px 16px; text-align:left; border:1px solid #4338CA;">Notes</th>
</tr>
</thead>
<tbody>
<tr style="background-color:#EEF2FF;">
<td style="padding:12px 16px; border:1px solid #C7D2FE;">FCDO Direct</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">~£30 per document</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">You handle everything yourself; can take several weeks</td>
</tr>
<tr>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Professional Services</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">£80–£100 per document</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Faster processing but certificate application separate</td>
</tr>
<tr style="background-color:#EEF2FF;">
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>PlaceMeNet Add-on</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>£180 / €200</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>Bundled with certificate — one application, one payment</strong></td>
</tr>
</tbody>
</table>
</div>

<p>While PlaceMeNet's apostille add-on appears more expensive than applying directly to the FCDO, it includes the convenience of bundling the apostille with your certificate application. You fill in one form, make one payment, and receive your certificate fully apostilled and ready for international use — saving you time and the hassle of navigating the FCDO process separately.</p>

<h2>Apostille vs Legalisation — What Is the Difference?</h2>

<p>People often confuse apostille with legalisation, but they serve different purposes and follow different processes:</p>

<div style="overflow-x:auto;">
<table style="width:100%; border-collapse:collapse; margin:1.5em 0;">
<thead>
<tr style="background-color:#312E81; color:#fff;">
<th style="padding:12px 16px; text-align:left; border:1px solid #4338CA;"></th>
<th style="padding:12px 16px; text-align:left; border:1px solid #4338CA;">Apostille</th>
<th style="padding:12px 16px; text-align:left; border:1px solid #4338CA;">Embassy Legalisation</th>
</tr>
</thead>
<tbody>
<tr style="background-color:#EEF2FF;">
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>Convention</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Hague Convention (1961)</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Not required</td>
</tr>
<tr>
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>Process</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Single step (FCDO only)</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Two steps (FCDO + embassy)</td>
</tr>
<tr style="background-color:#EEF2FF;">
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>Processing Time</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">1–3 weeks</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">3–8 weeks</td>
</tr>
<tr>
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>Cost</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Lower</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Higher (embassy fees on top)</td>
</tr>
<tr style="background-color:#EEF2FF;">
<td style="padding:12px 16px; border:1px solid #C7D2FE;"><strong>Accepted In</strong></td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">150+ Hague member countries</td>
<td style="padding:12px 16px; border:1px solid #C7D2FE;">Non-member countries (e.g. Canada, UAE)</td>
</tr>
</tbody>
</table>
</div>

<p>In short: if the destination country is a <strong>Hague Convention member</strong>, you need an apostille. If it is <strong>not a member</strong>, you need embassy legalisation.</p>

<h2>Which Countries Accept Apostilles?</h2>

<p>The Hague Apostille Convention has grown to include <strong>over 150 member countries</strong>. Here are some key regions and members:</p>

<ul>
<li><strong>All European Union member states</strong> — France, Germany, Spain, Italy, Netherlands, Greece, Portugal, and all others</li>
<li><strong>United Kingdom</strong> — the UK remained a member after Brexit</li>
<li><strong>United States</strong> — all 50 states accept apostilled documents</li>
<li><strong>Australia and New Zealand</strong></li>
<li><strong>Japan and South Korea</strong></li>
<li><strong>India</strong> — joined the Convention in 2023</li>
<li><strong>Most of Latin America</strong> — Brazil, Mexico, Argentina, Colombia, and others</li>
<li><strong>South Africa</strong></li>
</ul>

<h3>Notable Non-Members</h3>

<p>Some major countries are <strong>not</strong> members of the Hague Convention. For these, you will need full embassy legalisation instead of an apostille:</p>

<ul>
<li><strong>Canada</strong> — requires authentication by Global Affairs Canada plus embassy legalisation</li>
<li><strong>United Arab Emirates (UAE)</strong> — requires FCDO authentication plus UAE embassy legalisation</li>
<li><strong>China</strong> — for some document types (commercial documents) embassy legalisation is still required</li>
<li><strong>Qatar, Kuwait, and some other Gulf states</strong></li>
</ul>

<p>Always check the latest membership list on the <strong>Hague Conference on Private International Law (HCCH)</strong> website before applying, as new countries join regularly.</p>

<h2>Do Police Certificates Need an Apostille?</h2>

<p>In many cases, <strong>yes</strong>. Police certificates and criminal record checks are among the most commonly apostilled documents. Here are typical scenarios where an apostille is required:</p>

<ul>
<li><strong>UK ACRO Police Certificate</strong> — if you are using your UK police certificate for a job, visa, or residency application in another country (e.g. applying for a work visa in Spain or a residency permit in Greece), you will almost certainly need it apostilled by the FCDO. <a href="/uk-police-certificate">Apply for a UK Police Certificate through PlaceMeNet</a>.</li>
<li><strong>Greece Penal Record Certificate</strong> — Greek criminal record certificates used abroad typically need apostille from the Greek Ministry of Foreign Affairs. This is particularly common for Greeks living in the UK, Germany, or Australia. <a href="/greece-penal-record">Apply for a Greece Penal Record Certificate</a>.</li>
<li><strong>Portugal Criminal Record Certificate</strong> — Portuguese criminal records needed for employment or immigration in non-Portuguese-speaking countries will usually require an apostille. <a href="/portugal-criminal-record">Apply for a Portugal Criminal Record Certificate</a>.</li>
</ul>

<p>PlaceMeNet offers an <strong>apostille/legalisation add-on for £180 / €200</strong> that can be added to any of our certificate services. When you select this add-on, we handle the entire apostille process on your behalf — you receive your certificate already authenticated and ready for international use.</p>

<h2>Common Mistakes to Avoid</h2>

<p>When dealing with apostilles, these are the most frequent errors people make:</p>

<ol>
<li><strong>Submitting photocopies instead of originals</strong> — an apostille can only be attached to an original document or an officially certified copy. A regular photocopy will be rejected.</li>
<li><strong>Assuming all countries accept apostilles</strong> — if your destination country is not a Hague Convention member, you need embassy legalisation instead. Always verify membership first.</li>
<li><strong>Skipping required notarisation</strong> — some documents (particularly private documents like contracts) need to be notarised before they can be apostilled. The FCDO will reject documents that need notarisation but have not received it.</li>
<li><strong>Not allowing enough time</strong> — FCDO processing can take 2–4 weeks for postal applications. If you need your documents urgently, consider a premium or same-day service, or use a professional service like PlaceMeNet.</li>
<li><strong>Confusing apostille with certified translation</strong> — an apostille authenticates the document but does not translate it. If the destination country requires the document in their language, you will need a certified translation in addition to the apostille.</li>
</ol>

<h2>Frequently Asked Questions</h2>

<h3>How long does an apostille take?</h3>
<p>Through the FCDO in the UK, a standard postal application takes <strong>2–4 weeks</strong>. Premium and same-day services are available for urgent cases. When bundled with a PlaceMeNet certificate service, the apostille is processed as part of the overall application timeline.</p>

<h3>How long is an apostille valid?</h3>
<p>An apostille itself <strong>does not expire</strong>. However, the underlying document may have an expiry date or the receiving authority may require it to be recent (e.g. police certificates are often required to be less than 3–6 months old).</p>

<h3>Can I apostille a digital or electronic document?</h3>
<p>The Hague Conference has introduced an <strong>e-Apostille Programme</strong>, and some countries now issue electronic apostilles. However, many countries still require physical apostilles on printed documents. Check with the receiving authority whether they accept e-Apostilles.</p>

<h3>Do I need a certified translation as well as an apostille?</h3>
<p>Often, yes. An apostille certifies the authenticity of your document but does not translate it. If the destination country's official language is different from the document's language, you will likely need a <strong>certified translation</strong> alongside the apostilled document.</p>

<h3>What is the difference between an apostille and a notarised document?</h3>
<p>A <strong>notarised document</strong> has been witnessed and verified by a notary public — this confirms that signatures are genuine and the document was signed voluntarily. An <strong>apostille</strong> goes a step further by authenticating the notary's seal and signature (or the seal of the issuing authority) for international acceptance. In many cases, you need notarisation first, then apostille on top.</p>

<h3>Can I get an apostille myself, or do I need a service?</h3>
<p>You can apply directly to the FCDO yourself for UK documents. However, using a professional service saves time, reduces the risk of errors, and is especially convenient when combined with a certificate application. PlaceMeNet's apostille add-on handles everything for you.</p>

<h3>Is an apostille the same as legalisation?</h3>
<p>Not exactly. An apostille is a <strong>simplified form of legalisation</strong> that works between Hague Convention member countries. Full embassy legalisation is a separate, more complex process required for non-member countries. Both serve the same purpose — authenticating documents for international use — but through different mechanisms.</p>

<h3>Does Spain accept UK apostilled documents?</h3>
<p>Yes. Both Spain and the UK are members of the Hague Convention, so a UK document with an FCDO apostille is accepted in Spain. Many British citizens living in or relocating to Spain use apostilled police certificates and birth certificates regularly.</p>

<h3>Can PlaceMeNet help with apostille?</h3>
<p>Absolutely. PlaceMeNet offers an <strong>apostille/legalisation add-on for £180 / €200</strong> that can be added to any of our certificate services — <a href="/uk-police-certificate">UK Police Certificate</a>, <a href="/greece-penal-record">Greece Penal Record</a>, or <a href="/portugal-criminal-record">Portugal Criminal Record</a>. We handle the full process so you receive your certificate already authenticated for international use.</p>

<h3>What happens if my document is rejected without an apostille?</h3>
<p>If a foreign authority rejects your document because it lacks an apostille, you will need to go back and get it apostilled before resubmitting. This can cause <strong>significant delays</strong> to visa applications, job offers, or legal proceedings. It is always better to check apostille requirements before submitting documents abroad.</p>

<h2>How PlaceMeNet Can Help</h2>

<p>PlaceMeNet offers a streamlined <strong>apostille/legalisation add-on service for £180 / €200</strong>, available for all three of our certificate services:</p>

<ul>
<li><a href="/uk-police-certificate"><strong>UK Police Character Certificate</strong></a> — ACRO criminal record check with optional apostille</li>
<li><a href="/greece-penal-record"><strong>Greece Penal Record Certificate</strong></a> — Greek criminal record with optional apostille</li>
<li><a href="/portugal-criminal-record"><strong>Portugal Criminal Record Certificate</strong></a> — Portuguese criminal record with optional apostille</li>
</ul>

<p>When you add the apostille option to your application, everything is handled in <strong>one process</strong>: you fill in one application, make one payment, and receive your certificate fully apostilled and ready for international use. No need to deal with the FCDO or foreign ministries separately.</p>

<p>If you need a criminal record certificate with apostille for work, immigration, or any other purpose abroad, <a href="/uk-police-certificate">start your application today</a> and select the apostille add-on during the service and payment step.</p>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How long does an apostille take?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Through the FCDO in the UK, a standard postal application takes 2–4 weeks. Premium and same-day services are available for urgent cases. When bundled with a PlaceMeNet certificate service, the apostille is processed as part of the overall application timeline."
      }
    },
    {
      "@type": "Question",
      "name": "How long is an apostille valid?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "An apostille itself does not expire. However, the underlying document may have an expiry date or the receiving authority may require it to be recent (e.g. police certificates are often required to be less than 3–6 months old)."
      }
    },
    {
      "@type": "Question",
      "name": "Can I apostille a digital or electronic document?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The Hague Conference has introduced an e-Apostille Programme, and some countries now issue electronic apostilles. However, many countries still require physical apostilles on printed documents. Check with the receiving authority whether they accept e-Apostilles."
      }
    },
    {
      "@type": "Question",
      "name": "Do I need a certified translation as well as an apostille?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Often, yes. An apostille certifies the authenticity of your document but does not translate it. If the destination country's official language is different from the document's language, you will likely need a certified translation alongside the apostilled document."
      }
    },
    {
      "@type": "Question",
      "name": "What is the difference between an apostille and a notarised document?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "A notarised document has been witnessed and verified by a notary public. An apostille goes a step further by authenticating the notary's seal and signature for international acceptance. In many cases, you need notarisation first, then apostille on top."
      }
    },
    {
      "@type": "Question",
      "name": "Can I get an apostille myself, or do I need a service?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "You can apply directly to the FCDO yourself for UK documents. However, using a professional service saves time, reduces the risk of errors, and is especially convenient when combined with a certificate application."
      }
    },
    {
      "@type": "Question",
      "name": "Is an apostille the same as legalisation?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Not exactly. An apostille is a simplified form of legalisation that works between Hague Convention member countries. Full embassy legalisation is a separate, more complex process required for non-member countries."
      }
    },
    {
      "@type": "Question",
      "name": "Does Spain accept UK apostilled documents?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Both Spain and the UK are members of the Hague Convention, so a UK document with an FCDO apostille is accepted in Spain."
      }
    },
    {
      "@type": "Question",
      "name": "Can PlaceMeNet help with apostille?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. PlaceMeNet offers an apostille/legalisation add-on for £180 / €200 that can be added to any certificate service — UK Police Certificate, Greece Penal Record, or Portugal Criminal Record. We handle the full process so you receive your certificate already authenticated for international use."
      }
    },
    {
      "@type": "Question",
      "name": "What happens if my document is rejected without an apostille?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "If a foreign authority rejects your document because it lacks an apostille, you will need to go back and get it apostilled before resubmitting. This can cause significant delays to visa applications, job offers, or legal proceedings."
      }
    }
  ]
}
</script>
HTML;
    }
}
