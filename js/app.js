// /* =========================================================
//    MEMBERSHIP
// ========================================================= */

// async function submitJoin() {

//     const n =
//         document.getElementById('jN').value.trim();

//     const s =
//         document.getElementById('jS').value.trim();

//     const dept =
//         document.getElementById('jD').value;

//     const batch =
//         document.getElementById('jBa').value.trim();

//     const why =
//         document.getElementById('jW').value.trim();


//     if (!n || !s) {

//         alert(
//             'Please fill in Name and Student ID.'
//         );

//         return;
//     }


//     const button =
//         document.querySelector('.jform .btn-g');


//     if (button) {

//         button.disabled = true;

//         button.textContent =
//             'Submitting...';

//     }


//     try {

//         const response =
//             await fetch(
//                 'api/members.php',
//                 {

//                     method: 'POST',

//                     headers: {
//                         'Content-Type':
//                             'application/json'
//                     },

//                     body:
//                         JSON.stringify({

//                             name: n,

//                             student_id: s,

//                             department: dept,

//                             batch: batch,

//                             reason: why

//                         })

//                 }
//             );


//         const result =
//             await response.json();


//         if (
//             !response.ok ||
//             !result.success
//         ) {

//             throw new Error(
//                 result.message ||
//                 'Could not submit membership request.'
//             );

//         }


//         document.getElementById(
//             'jFormArea'
//         ).style.display = 'none';


//         document.getElementById(
//             'jSucc'
//         ).style.display = 'block';


//         document.getElementById(
//             'jMidShow'
//         ).textContent =
//             result.member_id;


//         document.getElementById(
//             'jNameShow'
//         ).textContent =
//             result.name;


//     } catch (error) {

//         console.error(error);

//         alert(
//             error.message ||
//             'Something went wrong. Please try again.'
//         );


//         if (button) {

//             button.disabled = false;

//             button.textContent =
//                 '✦ Submit Membership Request';

//         }

//     }

// }



// /* =========================================================
//    DONATION
// ========================================================= */

// async function submitDonation() {

//     const n =
//         document.getElementById('dName').value.trim();

//     const p =
//         document.getElementById('dPhone').value.trim();

//     const sender =
//         document.getElementById('dSender').value.trim();

//     const trx =
//         document.getElementById('dTrx').value.trim();

//     const amt =
//         document.getElementById('dAmt').value.trim();

//     const note =
//         document.getElementById('dNote').value.trim();


//     if (
//         !n ||
//         !p ||
//         !sender ||
//         !trx ||
//         !amt ||
//         Number(amt) <= 0
//     ) {

//         alert(
//             'Please fill in Name, Phone, bKash Number, Transaction ID and a valid Amount.'
//         );

//         return;
//     }


//     const button =
//         document.querySelector('#donF .btn-g');


//     if (button) {

//         button.disabled = true;

//         button.textContent =
//             'Submitting...';

//     }


//     try {

//         const response =
//             await fetch(
//                 'api/donations.php',
//                 {

//                     method: 'POST',

//                     headers: {
//                         'Content-Type':
//                             'application/json'
//                     },

//                     body:
//                         JSON.stringify({

//                             name: n,

//                             phone: p,

//                             bkash_number: sender,

//                             trx_id: trx,

//                             amount: Number(amt),

//                             campaign_id: null,

//                             cause_id: null,

//                             note: note

//                         })

//                 }
//             );


//         const result =
//             await response.json();


//         if (
//             !response.ok ||
//             !result.success
//         ) {

//             throw new Error(
//                 result.message ||
//                 'Could not submit donation.'
//             );

//         }


//         document.getElementById(
//             'donF'
//         ).style.display = 'none';


//         document.getElementById(
//             'donSucc'
//         ).style.display = 'block';


//     } catch (error) {

//         console.error(error);

//         alert(
//             error.message ||
//             'Something went wrong. Please try again.'
//         );


//         if (button) {

//             button.disabled = false;

//             button.textContent =
//                 '✦ Submit Donation Details';

//         }

//     }

// }



// /* =========================================================
//    EVENT REGISTRATION
// ========================================================= */

// let selectedEventId = null;


// /* =========================================================
//    LOAD EVENTS
// ========================================================= */

// async function loadEvents() {

//     const grid = document.getElementById("evGrid");

//     if (!grid) {
//         return;
//     }

//     try {

//         const response = await fetch("api/events.php");

//         const result = await response.json();

//         if (!response.ok || !result.success) {
//             throw new Error(
//                 result.message || "Could not load events."
//             );
//         }

//         grid.innerHTML = "";

//         const events = result.events || [];

//         if (events.length === 0) {

//             grid.innerHTML = `
//                 <p style="text-align:center;">
//                     No upcoming events at the moment.
//                 </p>
//             `;

//             return;
//         }


//         events.forEach(function(event) {

//             const card = document.createElement("div");

//             card.className = "ecard";


//             /* Format date */

//             const eventDate = new Date(
//                 event.event_date + "T00:00:00"
//             );

//             const formattedDate =
//                 eventDate.toLocaleDateString(
//                     "en-US",
//                     {
//                         month: "long",
//                         day: "numeric",
//                         year: "numeric"
//                     }
//                 );


//             /* Format time */

//             let formattedTime = event.event_time || "";

//             if (event.event_time) {

//                 const parts =
//                     event.event_time.split(":");

//                 let hour =
//                     parseInt(parts[0], 10);

//                 const minute =
//                     parts[1];

//                 const ampm =
//                     hour >= 12 ? "PM" : "AM";

//                 hour =
//                     hour % 12 || 12;

//                 formattedTime =
//                     hour + ":" + minute + " " + ampm;
//             }


//             /* Card */

//             card.innerHTML = `

//                 <div class="ecard-top">

//                     <div class="edate">
//                         📅 ${formattedDate}
//                     </div>

//                 </div>


//                 <div class="ecard-body">

//                     <h3 class="etitle">
//                         ${escapeHtml(event.title)}
//                     </h3>

//                     <p class="edesc">
//                         ${escapeHtml(event.description || "")}
//                     </p>


//                     <div class="emeta">

//                         <span>
//                             🕐 ${formattedTime}
//                         </span>

//                         <span>
//                             📍 ${escapeHtml(event.location || "")}
//                         </span>

//                         <span>
//                             👥 ${event.seats} seats
//                         </span>

//                     </div>


//                     <button
//                         type="button"
//                         class="btn-g bfull register-event-btn"
//                     >
//                         Register Now ✦
//                     </button>

//                 </div>
//             `;


//             /* Register button */

//             const registerButton =
//                 card.querySelector(".register-event-btn");


//             registerButton.addEventListener(
//                 "click",
//                 function() {

//                     console.log(
//                         "Register clicked:",
//                         event.id,
//                         event.title
//                     );

//                     openReg(
//                         event.id,
//                         event.title
//                     );

//                 }
//             );


//             grid.appendChild(card);

//         });


//     } catch (error) {

//         console.error(
//             "Event loading error:",
//             error
//         );

//         grid.innerHTML = `
//             <p style="
//                 text-align:center;
//                 color:red;
//             ">
//                 Could not load events.
//             </p>
//         `;
//     }
// }


// /* =========================================================
//    OPEN REGISTRATION MODAL
// ========================================================= */

// function openReg(eventId, eventTitle) {

//     console.log(
//         "Opening registration modal:",
//         eventId,
//         eventTitle
//     );


//     selectedEventId = eventId;


//     const modal =
//         document.getElementById("regMov");

//     const form =
//         document.getElementById("regF");

//     const success =
//         document.getElementById("regSucc");

//     const eventName =
//         document.getElementById("regEvName");


//     if (!modal) {

//         console.error(
//             "ERROR: regMov was not found."
//         );

//         return;
//     }


//     /* Show form */

//     if (form) {
//         form.style.display = "block";
//     }


//     /* Hide success */

//     if (success) {
//         success.style.display = "none";
//     }


//     /* Show event name */

//     if (eventName) {
//         eventName.textContent =
//             eventTitle;
//     }


//     /* Clear old inputs */

//     const nameInput =
//         document.getElementById("rN");

//     const studentInput =
//         document.getElementById("rS");

//     const departmentInput =
//         document.getElementById("rD");

//     const batchInput =
//         document.getElementById("rB");


//     if (nameInput) {
//         nameInput.value = "";
//     }

//     if (studentInput) {
//         studentInput.value = "";
//     }

//     if (departmentInput) {
//         departmentInput.value = "";
//     }

//     if (batchInput) {
//         batchInput.value = "";
//     }


//     /* Open modal */

//     modal.classList.add("open");

//     document.body.style.overflow = "hidden";

// }


// /* =========================================================
//    CLOSE REGISTRATION MODAL
// ========================================================= */

// function closeReg() {

//     const modal =
//         document.getElementById("regMov");

//     if (modal) {

//         modal.classList.remove("open");

//     }

//     document.body.style.overflow = "";

// }


// /* =========================================================
//    SUBMIT REGISTRATION
// ========================================================= */

// async function submitReg() {

//     const name =
//         document.getElementById("rN")
//             .value
//             .trim();

//     const studentId =
//         document.getElementById("rS")
//             .value
//             .trim();

//     const department =
//         document.getElementById("rD")
//             .value;

//     const batch =
//         document.getElementById("rB")
//             .value
//             .trim();


//     if (
//         !name ||
//         !studentId ||
//         !department ||
//         !batch
//     ) {

//         alert(
//             "Please fill in all registration fields."
//         );

//         return;
//     }


//     if (!selectedEventId) {

//         alert(
//             "Please select an event first."
//         );

//         return;
//     }


//     const button =
//         document.querySelector(
//             "#regF .btn-g"
//         );


//     if (button) {

//         button.disabled = true;

//         button.textContent =
//             "Submitting...";

//     }


//     try {

//         const response =
//             await fetch(
//                 "api/event_registrations.php",
//                 {

//                     method: "POST",

//                     headers: {
//                         "Content-Type":
//                             "application/json"
//                     },

//                     body: JSON.stringify({

//                         event_id:
//                             selectedEventId,

//                         name:
//                             name,

//                         student_id:
//                             studentId,

//                         department:
//                             department,

//                         batch:
//                             batch

//                     })

//                 }
//             );


//         const result =
//             await response.json();


//         if (
//             !response.ok ||
//             !result.success
//         ) {

//             throw new Error(
//                 result.message ||
//                 "Could not complete registration."
//             );

//         }


//         document.getElementById(
//             "regF"
//         ).style.display = "none";


//         document.getElementById(
//             "regSucc"
//         ).style.display = "block";


//     } catch (error) {

//         console.error(
//             "Registration error:",
//             error
//         );


//         alert(
//             error.message ||
//             "Something went wrong. Please try again."
//         );


//         if (button) {

//             button.disabled = false;

//             button.textContent =
//                 "✦ Confirm Registration";

//         }

//     }

// }


// /* =========================================================
//    HTML ESCAPING
// ========================================================= */

// function escapeHtml(value) {

//     return String(value)
//         .replace(/&/g, "&amp;")
//         .replace(/</g, "&lt;")
//         .replace(/>/g, "&gt;")
//         .replace(/"/g, "&quot;")
//         .replace(/'/g, "&#039;");

// }


// /* =========================================================
//    START
// ========================================================= */

// document.addEventListener(
//     "DOMContentLoaded",
//     function() {

//         loadEvents();

//     }
// );

// /* =========================================================
//    TAB SWITCHING
// ========================================================= */

// function swTab(name, button) {

//     document.querySelectorAll(".tpane").forEach(function (pane) {
//         pane.classList.remove("active");
//     });

//     document.querySelectorAll(".tbtn").forEach(function (btn) {
//         btn.classList.remove("active");
//     });

//     const pane = document.getElementById("tp-" + name);

//     if (pane) {
//         pane.classList.add("active");
//     }

//     if (button) {
//         button.classList.add("active");
//     }
// }


// /* =========================================================
//    NOTICES
// ========================================================= */

// async function loadNotices() {

//     const list = document.getElementById("notList");

//     if (!list) return;

//     try {

//         const response = await fetch("api/notices.php");

//         const result = await response.json();

//         if (!response.ok || !result.success) {
//             throw new Error(result.message || "Could not load notices.");
//         }

//         const notices = result.notices || [];

//         if (notices.length === 0) {

//             list.innerHTML = `
//                 <div class="nores">
//                     No notices available at the moment.
//                 </div>
//             `;

//             return;
//         }

//         list.innerHTML = "";

//         notices.forEach(function (notice) {

//             const item = document.createElement("div");

//             item.className = "ni " + (notice.type || "info");

//             item.innerHTML = `
//                 <div class="nico">
//                     ${escapeHtml(notice.icon || "📢")}
//                 </div>

//                 <div>
//                     <div class="ntag">
//                         ${escapeHtml(notice.type || "Notice")}
//                     </div>

//                     <div class="ntit">
//                         ${escapeHtml(notice.title)}
//                     </div>

//                     <div class="ndesc">
//                         ${escapeHtml(notice.content)}
//                     </div>

//                     ${
//                         notice.notice_date
//                             ? `<div class="rsrc">
//                                 ${escapeHtml(notice.notice_date)}
//                                </div>`
//                             : ""
//                     }
//                 </div>
//             `;

//             list.appendChild(item);
//         });

//     } catch (error) {

//         console.error("Notice loading error:", error);

//         list.innerHTML = `
//             <div class="nores">
//                 Could not load notices.
//             </div>
//         `;
//     }
// }


// /* =========================================================
//    ISLAMIC RESOURCES
// ========================================================= */

// async function loadResources() {

//     const ayah = document.getElementById("gAyah");
//     const hadith = document.getElementById("gHadith");
//     const articles = document.getElementById("gArt");

//     if (!ayah && !hadith && !articles) return;

//     try {

//         const response = await fetch("api/resources.php");

//         const result = await response.json();

//         if (!response.ok || !result.success) {
//             throw new Error(
//                 result.message || "Could not load resources."
//             );
//         }

//         const resources = result.resources || [];

//         if (ayah) ayah.innerHTML = "";
//         if (hadith) hadith.innerHTML = "";
//         if (articles) articles.innerHTML = "";

//         resources.forEach(function (resource) {

//             const card = document.createElement("div");

//             card.className = "rc";

//             card.innerHTML = `

//                 <div class="rtype">
//                     ${escapeHtml(resource.type)}
//                 </div>

//                 ${
//                     resource.arabic
//                         ? `
//                             <div class="rarabic">
//                                 ${escapeHtml(resource.arabic)}
//                             </div>
//                           `
//                         : ""
//                 }

//                 <div class="rtrans">
//                     ${escapeHtml(resource.content)}
//                 </div>

//                 ${
//                     resource.source
//                         ? `
//                             <div class="rsrc">
//                                 ${escapeHtml(resource.source)}
//                             </div>
//                           `
//                         : ""
//                 }

//                 ${
//                     resource.author
//                         ? `
//                             <div class="rsrc">
//                                 ${escapeHtml(resource.author)}
//                             </div>
//                           `
//                         : ""
//                 }
//             `;

//             if (resource.type === "ayah" && ayah) {
//                 ayah.appendChild(card);
//             }

//             else if (resource.type === "hadith" && hadith) {
//                 hadith.appendChild(card);
//             }

//             else if (resource.type === "article" && articles) {
//                 articles.appendChild(card);
//             }

//         });

//         if (ayah && !ayah.children.length) {
//             ayah.innerHTML =
//                 `<div class="nores">No Ayah available.</div>`;
//         }

//         if (hadith && !hadith.children.length) {
//             hadith.innerHTML =
//                 `<div class="nores">No Hadith available.</div>`;
//         }

//         if (articles && !articles.children.length) {
//             articles.innerHTML =
//                 `<div class="nores">No articles available.</div>`;
//         }

//     } catch (error) {

//         console.error("Resource loading error:", error);

//         const message =
//             `<div class="nores">Could not load resources.</div>`;

//         if (ayah) ayah.innerHTML = message;
//         if (hadith) hadith.innerHTML = message;
//         if (articles) articles.innerHTML = message;
//     }
// }


// /* =========================================================
//    DONATION DATA
// ========================================================= */

// let selectedDonationTarget = {
//     campaign_id: null,
//     cause_id: null
// };


// function openDonate(title, campaignId = null, causeId = null) {

//     selectedDonationTarget = {
//         campaign_id: campaignId,
//         cause_id: causeId
//     };

//     const modal = document.getElementById("donMov");

//     const form = document.getElementById("donF");

//     const success = document.getElementById("donSucc");

//     const titleElement = document.getElementById("donTitle");

//     if (!modal) return;

//     if (form) {
//         form.style.display = "block";
//     }

//     if (success) {
//         success.style.display = "none";
//     }

//     if (titleElement) {
//         titleElement.textContent =
//             title || "Donate via bKash";
//     }

//     modal.classList.add("open");

//     document.body.style.overflow = "hidden";
// }


// function closeDonate() {

//     const modal =
//         document.getElementById("donMov");

//     if (modal) {
//         modal.classList.remove("open");
//     }

//     document.body.style.overflow = "";
// }


// /* =========================================================
//    LOAD DONATION / FUNDRAISING DATA
// ========================================================= */

// async function loadDonationData() {

//     const campGrid =
//         document.getElementById("campGrid");

//     const causeGrid =
//         document.getElementById("causeGrid");

//     const cdGrid =
//         document.getElementById("cdGrid");

//     const genRaised =
//         document.getElementById("genRaised");

//     const campRaisedTotal =
//         document.getElementById("campRaisedTotal");

//     if (
//         !campGrid &&
//         !causeGrid &&
//         !cdGrid
//     ) {
//         return;
//     }

//     try {

//         const response =
//             await fetch("api/public_donations.php");

//         const result =
//             await response.json();

//         if (
//             !response.ok ||
//             !result.success
//         ) {
//             throw new Error(
//                 result.message ||
//                 "Could not load donation information."
//             );
//         }


//         if (genRaised) {

//             genRaised.textContent =
//                 "৳" +
//                 Number(
//                     result.general_raised || 0
//                 ).toLocaleString();
//         }


//         if (campRaisedTotal) {

//             campRaisedTotal.textContent =
//                 "৳" +
//                 Number(
//                     result.campaign_raised || 0
//                 ).toLocaleString();
//         }


//         /* -----------------------------------------
//            EVENT / ACTIVITY FUNDRAISING
//         ----------------------------------------- */

//         if (campGrid) {

//             campGrid.innerHTML = "";

//             const campaigns =
//                 result.campaigns || [];

//             if (campaigns.length === 0) {

//                 campGrid.innerHTML = `
//                     <div class="nores">
//                         No event or activity fundraising campaigns
//                         are available right now.
//                     </div>
//                 `;

//             } else {

//                 campaigns.forEach(function (campaign) {

//                     const card =
//                         document.createElement("div");

//                     card.className = "ecard";

//                     const target =
//                         Number(campaign.goal_amount || 0);

//                     const raised =
//                         Number(campaign.raised_amount || 0);

//                     const percentage =
//                         target > 0
//                             ? Math.min(
//                                 100,
//                                 Math.round(
//                                     raised / target * 100
//                                 )
//                             )
//                             : 0;

//                     card.innerHTML = `

//                         <div class="ebar"></div>

//                         <div class="ebody">

//                             <div class="edate">
//                                 🤝 Fundraising
//                             </div>

//                             <h3 class="etitle">
//                                 ${escapeHtml(campaign.title)}
//                             </h3>

//                             <p class="edesc">
//                                 ${escapeHtml(
//                                     campaign.description || ""
//                                 )}
//                             </p>

//                             <div class="emeta">
//                                 <span>
//                                     💰 Raised:
//                                     ৳${raised.toLocaleString()}
//                                 </span>

//                                 <span>
//                                     🎯 Goal:
//                                     ৳${target.toLocaleString()}
//                                 </span>
//                             </div>

//                             <div style="
//                                 height:8px;
//                                 background:#eadcf3;
//                                 border-radius:20px;
//                                 overflow:hidden;
//                                 margin:1rem 0;
//                             ">
//                                 <div style="
//                                     width:${percentage}%;
//                                     height:100%;
//                                     background:linear-gradient(
//                                         to right,
//                                         var(--rose),
//                                         var(--gold)
//                                     );
//                                 "></div>
//                             </div>

//                             <button
//                                 class="btn-g bfull"
//                                 type="button"
//                                 onclick="openDonate(
//                                     '${escapeHtml(campaign.title)}',
//                                     ${campaign.id},
//                                     null
//                                 )"
//                             >
//                                 🤲 Donate via bKash
//                             </button>

//                         </div>
//                     `;

//                     campGrid.appendChild(card);
//                 });
//             }
//         }


//         /* -----------------------------------------
//            CAUSES
//         ----------------------------------------- */

//         if (causeGrid) {

//             causeGrid.innerHTML = "";

//             const causes =
//                 result.causes || [];

//             if (causes.length === 0) {

//                 causeGrid.innerHTML = `
//                     <div class="nores">
//                         No specific causes are available.
//                         You can still make a general donation below.
//                     </div>

//                     <div class="ecard">

//                         <div class="ebar"></div>

//                         <div class="ebody">

//                             <div class="edate">
//                                 💗 General Donation
//                             </div>

//                             <h3 class="etitle">
//                                 Support SEC Muslimah
//                             </h3>

//                             <p class="edesc">
//                                 Support the general activities,
//                                 educational programs and community
//                                 work of SEC Muslimah.
//                             </p>

//                             <button
//                                 class="btn-g bfull"
//                                 type="button"
//                                 onclick="openDonate(
//                                     'General SEC Muslimah Donation'
//                                 )"
//                             >
//                                 🤲 Donate via bKash
//                             </button>

//                         </div>

//                     </div>
//                 `;

//             } else {

//                 causes.forEach(function (cause) {

//                     const card =
//                         document.createElement("div");

//                     card.className = "ecard";

//                     const target =
//                         Number(cause.goal_amount || 0);

//                     const raised =
//                         Number(cause.raised_amount || 0);

//                     const percentage =
//                         target > 0
//                             ? Math.min(
//                                 100,
//                                 Math.round(
//                                     raised / target * 100
//                                 )
//                             )
//                             : 0;

//                     card.innerHTML = `

//                         <div class="ebar"></div>

//                         <div class="ebody">

//                             <div class="edate">
//                                 💗 Donation Cause
//                             </div>

//                             <h3 class="etitle">
//                                 ${escapeHtml(cause.title)}
//                             </h3>

//                             <p class="edesc">
//                                 ${escapeHtml(
//                                     cause.description || ""
//                                 )}
//                             </p>

//                             <div class="emeta">
//                                 <span>
//                                     💰 Raised:
//                                     ৳${raised.toLocaleString()}
//                                 </span>

//                                 <span>
//                                     🎯 Goal:
//                                     ৳${target.toLocaleString()}
//                                 </span>
//                             </div>

//                             <div style="
//                                 height:8px;
//                                 background:#eadcf3;
//                                 border-radius:20px;
//                                 overflow:hidden;
//                                 margin:1rem 0;
//                             ">
//                                 <div style="
//                                     width:${percentage}%;
//                                     height:100%;
//                                     background:linear-gradient(
//                                         to right,
//                                         var(--rose),
//                                         var(--gold)
//                                     );
//                                 "></div>
//                             </div>

//                             <button
//                                 class="btn-g bfull"
//                                 type="button"
//                                 onclick="openDonate(
//                                     '${escapeHtml(cause.title)}',
//                                     null,
//                                     ${cause.id}
//                                 )"
//                             >
//                                 🤲 Donate via bKash
//                             </button>

//                         </div>
//                     `;

//                     causeGrid.appendChild(card);
//                 });
//             }
//         }


//         /* -----------------------------------------
//            CLOTHES COLLECTION
//         ----------------------------------------- */

//         if (cdGrid) {

//             cdGrid.innerHTML = "";

//             const clothes =
//                 result.clothes || [];

//             if (clothes.length === 0) {

//                 cdGrid.innerHTML = `
//                     <div class="nores">
//                         No clothes collection drive is active
//                         right now.
//                     </div>
//                 `;

//             } else {

//                 clothes.forEach(function (drive) {

//                     const card =
//                         document.createElement("div");

//                     card.className = "ecard";

//                     card.innerHTML = `

//                         <div class="ebar"></div>

//                         <div class="ebody">

//                             <div class="edate">
//                                 🧥 Clothes Collection
//                             </div>

//                             <h3 class="etitle">
//                                 ${escapeHtml(drive.title)}
//                             </h3>

//                             <p class="edesc">
//                                 ${escapeHtml(
//                                     drive.description || ""
//                                 )}
//                             </p>

//                             <div class="emeta">
//                                 <span>
//                                     📍 ${escapeHtml(
//                                         drive.dropoff_location || ""
//                                     )}
//                                 </span>

//                                 ${
//                                     drive.deadline
//                                         ? `
//                                             <span>
//                                                 📅 ${escapeHtml(
//                                                     drive.deadline
//                                                 )}
//                                             </span>
//                                           `
//                                         : ""
//                                 }
//                             </div>

//                             <button
//                                 class="btn-g bfull"
//                                 type="button"
//                                 onclick="openPledge(
//                                     ${drive.id},
//                                     '${escapeHtml(drive.title)}'
//                                 )"
//                             >
//                                 🧥 Pledge Clothes
//                             </button>

//                         </div>
//                     `;

//                     cdGrid.appendChild(card);
//                 });
//             }
//         }

//     } catch (error) {

//         console.error(
//             "Donation loading error:",
//             error
//         );

//         if (campGrid) {
//             campGrid.innerHTML =
//                 `<div class="nores">Could not load fundraising data.</div>`;
//         }

//         if (causeGrid) {
//             causeGrid.innerHTML =
//                 `<div class="nores">Could not load donation data.</div>`;
//         }

//         if (cdGrid) {
//             cdGrid.innerHTML =
//                 `<div class="nores">Could not load clothes drives.</div>`;
//         }
//     }
// }


// /* =========================================================
//    UPDATE DONATION SUBMISSION
// ========================================================= */

// async function submitDonation() {

//     const n =
//         document.getElementById("dName").value.trim();

//     const p =
//         document.getElementById("dPhone").value.trim();

//     const sender =
//         document.getElementById("dSender").value.trim();

//     const trx =
//         document.getElementById("dTrx").value.trim();

//     const amt =
//         document.getElementById("dAmt").value.trim();

//     const note =
//         document.getElementById("dNote").value.trim();


//     if (
//         !n ||
//         !p ||
//         !sender ||
//         !trx ||
//         !amt ||
//         Number(amt) <= 0
//     ) {

//         alert(
//             "Please fill in Name, Phone, bKash Number, Transaction ID and a valid Amount."
//         );

//         return;
//     }


//     const button =
//         document.querySelector("#donF .btn-g");


//     if (button) {

//         button.disabled = true;

//         button.textContent =
//             "Submitting...";

//     }


//     try {

//         const response =
//             await fetch(
//                 "api/donations.php",
//                 {
//                     method: "POST",

//                     headers: {
//                         "Content-Type":
//                             "application/json"
//                     },

//                     body: JSON.stringify({

//                         name: n,

//                         phone: p,

//                         bkash_number: sender,

//                         trx_id: trx,

//                         amount: Number(amt),

//                         campaign_id:
//                             selectedDonationTarget.campaign_id,

//                         cause_id:
//                             selectedDonationTarget.cause_id,

//                         note: note

//                     })
//                 }
//             );


//         const result =
//             await response.json();


//         if (
//             !response.ok ||
//             !result.success
//         ) {

//             throw new Error(
//                 result.message ||
//                 "Could not submit donation."
//             );

//         }


//         document.getElementById(
//             "donF"
//         ).style.display = "none";


//         document.getElementById(
//             "donSucc"
//         ).style.display = "block";


//     } catch (error) {

//         console.error(error);

//         alert(
//             error.message ||
//             "Something went wrong. Please try again."
//         );


//         if (button) {

//             button.disabled = false;

//             button.textContent =
//                 "✦ Submit Donation Details";

//         }

//     }
// }


// /* =========================================================
//    START ALL PUBLIC CONTENT
// ========================================================= */

// document.addEventListener(
//     "DOMContentLoaded",
//     function () {

//         loadEvents();

//         loadNotices();

//         loadResources();

//         loadDonationData();

//     }
// );

/* =========================================================
   SEC MUSLIMAH - PUBLIC APP.JS
   ========================================================= */


/* =========================================================
   MEMBERSHIP
========================================================= */

async function submitJoin() {

    const nameInput = document.getElementById("jN");
    const studentInput = document.getElementById("jS");
    const departmentInput = document.getElementById("jD");
    const batchInput = document.getElementById("jBa");
    const reasonInput = document.getElementById("jW");

    if (!nameInput || !studentInput) {
        return;
    }

    const name = nameInput.value.trim();
    const studentId = studentInput.value.trim();
    const department = departmentInput
        ? departmentInput.value
        : "";
    const batch = batchInput
        ? batchInput.value.trim()
        : "";
    const reason = reasonInput
        ? reasonInput.value.trim()
        : "";

    if (!name || !studentId) {
        alert("Please fill in Name and Student ID.");
        return;
    }

    const button =
        document.querySelector(".jform .btn-g");

    if (button) {
        button.disabled = true;
        button.textContent = "Submitting...";
    }

    try {

        const response = await fetch(
            "api/members.php",
            {
                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify({
                    name: name,
                    student_id: studentId,
                    department: department,
                    batch: batch,
                    reason: reason
                })
            }
        );

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                "Could not submit membership request."
            );
        }

        const formArea =
            document.getElementById("jFormArea");

        const successArea =
            document.getElementById("jSucc");

        const memberId =
            document.getElementById("jMidShow");

        const memberName =
            document.getElementById("jNameShow");

        if (formArea) {
            formArea.style.display = "none";
        }

        if (successArea) {
            successArea.style.display = "block";
        }

        if (memberId) {
            memberId.textContent =
                result.member_id || "";
        }

        if (memberName) {
            memberName.textContent =
                result.name || name;
        }

    } catch (error) {

        console.error(
            "Membership error:",
            error
        );

        alert(
            error.message ||
            "Something went wrong. Please try again."
        );

        if (button) {
            button.disabled = false;
            button.textContent =
                "✦ Submit Membership Request";
        }
    }
}


/* =========================================================
   EVENT REGISTRATION
========================================================= */

let selectedEventId = null;


/* =========================================================
   LOAD EVENTS
========================================================= */

async function loadEvents() {

    const grid =
        document.getElementById("evGrid");

    if (!grid) {
        return;
    }

    try {

        const response =
            await fetch("api/events.php");

        const result =
            await response.json();

        if (!response.ok || !result.success) {
            throw new Error(
                result.message ||
                "Could not load events."
            );
        }

        grid.innerHTML = "";

        const events =
            result.events || [];

        if (events.length === 0) {

            grid.innerHTML = `
                <p style="text-align:center;">
                    No upcoming events at the moment.
                </p>
            `;

            return;
        }

        events.forEach(function (event) {

            const card =
                document.createElement("div");

            card.className = "ecard";


            /* Date */

            let formattedDate =
                event.event_date || "";

            if (event.event_date) {

                const eventDate =
                    new Date(
                        event.event_date +
                        "T00:00:00"
                    );

                if (!Number.isNaN(
                    eventDate.getTime()
                )) {

                    formattedDate =
                        eventDate.toLocaleDateString(
                            "en-US",
                            {
                                month: "long",
                                day: "numeric",
                                year: "numeric"
                            }
                        );
                }
            }


            /* Time */

            let formattedTime =
                event.event_time || "";

            if (event.event_time) {

                const parts =
                    event.event_time.split(":");

                let hour =
                    parseInt(parts[0], 10);

                const minute =
                    parts[1] || "00";

                if (!Number.isNaN(hour)) {

                    const ampm =
                        hour >= 12
                            ? "PM"
                            : "AM";

                    hour =
                        hour % 12 || 12;

                    formattedTime =
                        hour +
                        ":" +
                        minute +
                        " " +
                        ampm;
                }
            }


            card.innerHTML = `

                <div class="ecard-top">

                    <div class="edate">
                        📅 ${escapeHtml(
                            formattedDate
                        )}
                    </div>

                </div>


                <div class="ecard-body">

                    <h3 class="etitle">
                        ${escapeHtml(
                            event.title || ""
                        )}
                    </h3>


                    <p class="edesc">
                        ${escapeHtml(
                            event.description || ""
                        )}
                    </p>


                    <div class="emeta">

                        <span>
                            🕐 ${escapeHtml(
                                formattedTime
                            )}
                        </span>

                        <span>
                            📍 ${escapeHtml(
                                event.location || ""
                            )}
                        </span>

                        <span>
                            👥 ${escapeHtml(
                                event.seats || 0
                            )} seats
                        </span>

                    </div>


                    <button
                        type="button"
                        class="btn-g bfull register-event-btn"
                    >
                        Register Now ✦
                    </button>

                </div>
            `;


            const registerButton =
                card.querySelector(
                    ".register-event-btn"
                );

            if (registerButton) {

                registerButton.addEventListener(
                    "click",
                    function () {

                        openReg(
                            event.id,
                            event.title || ""
                        );

                    }
                );
            }


            grid.appendChild(card);

        });

    } catch (error) {

        console.error(
            "Event loading error:",
            error
        );

        grid.innerHTML = `
            <p style="
                text-align:center;
                color:red;
            ">
                Could not load events.
            </p>
        `;
    }
}


/* =========================================================
   OPEN REGISTRATION MODAL
========================================================= */

function openReg(
    eventId,
    eventTitle
) {

    selectedEventId =
        eventId;

    const modal =
        document.getElementById("regMov");

    const form =
        document.getElementById("regF");

    const success =
        document.getElementById("regSucc");

    const eventName =
        document.getElementById("regEvName");


    if (!modal) {

        console.error(
            "Registration modal #regMov was not found."
        );

        return;
    }


    if (form) {
        form.style.display = "block";
    }


    if (success) {
        success.style.display = "none";
    }


    if (eventName) {
        eventName.textContent =
            eventTitle || "";
    }


    const nameInput =
        document.getElementById("rN");

    const studentInput =
        document.getElementById("rS");

    const departmentInput =
        document.getElementById("rD");

    const batchInput =
        document.getElementById("rB");


    if (nameInput) {
        nameInput.value = "";
    }

    if (studentInput) {
        studentInput.value = "";
    }

    if (departmentInput) {
        departmentInput.value = "";
    }

    if (batchInput) {
        batchInput.value = "";
    }


    modal.classList.add("open");

    document.body.style.overflow =
        "hidden";
}


/* =========================================================
   CLOSE REGISTRATION MODAL
========================================================= */

function closeReg() {

    const modal =
        document.getElementById("regMov");

    if (modal) {
        modal.classList.remove("open");
    }

    document.body.style.overflow = "";
}


/* =========================================================
   SUBMIT EVENT REGISTRATION
========================================================= */

async function submitReg() {

    const nameElement =
        document.getElementById("rN");

    const studentElement =
        document.getElementById("rS");

    const departmentElement =
        document.getElementById("rD");

    const batchElement =
        document.getElementById("rB");


    if (
        !nameElement ||
        !studentElement ||
        !departmentElement ||
        !batchElement
    ) {
        return;
    }


    const name =
        nameElement.value.trim();

    const studentId =
        studentElement.value.trim();

    const department =
        departmentElement.value;

    const batch =
        batchElement.value.trim();


    if (
        !name ||
        !studentId ||
        !department ||
        !batch
    ) {

        alert(
            "Please fill in all registration fields."
        );

        return;
    }


    if (!selectedEventId) {

        alert(
            "Please select an event first."
        );

        return;
    }


    const button =
        document.querySelector(
            "#regF .btn-g"
        );


    if (button) {

        button.disabled = true;

        button.textContent =
            "Submitting...";
    }


    try {

        const response =
            await fetch(
                "api/event_registrations.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    body: JSON.stringify({

                        event_id:
                            selectedEventId,

                        name:
                            name,

                        student_id:
                            studentId,

                        department:
                            department,

                        batch:
                            batch

                    })
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ||
                "Could not complete registration."
            );
        }


        const form =
            document.getElementById(
                "regF"
            );

        const success =
            document.getElementById(
                "regSucc"
            );


        if (form) {
            form.style.display =
                "none";
        }


        if (success) {
            success.style.display =
                "block";
        }


    } catch (error) {

        console.error(
            "Registration error:",
            error
        );

        alert(
            error.message ||
            "Something went wrong. Please try again."
        );


        if (button) {

            button.disabled =
                false;

            button.textContent =
                "✦ Confirm Registration";
        }
    }
}


/* =========================================================
   TAB SWITCHING
========================================================= */

function swTab(
    name,
    button
) {

    document
        .querySelectorAll(".tpane")
        .forEach(function (pane) {

            pane.classList.remove(
                "active"
            );

        });


    document
        .querySelectorAll(".tbtn")
        .forEach(function (btn) {

            btn.classList.remove(
                "active"
            );

        });


    const pane =
        document.getElementById(
            "tp-" + name
        );


    if (pane) {

        pane.classList.add(
            "active"
        );
    }


    if (button) {

        button.classList.add(
            "active"
        );
    }
}


/* =========================================================
   NOTICES
========================================================= */

async function loadNotices() {

    const list =
        document.getElementById(
            "notList"
        );


    if (!list) {
        return;
    }


    try {

        const response =
            await fetch(
                "api/notices.php"
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ||
                "Could not load notices."
            );
        }


        const notices =
            result.notices || [];


        if (notices.length === 0) {

            list.innerHTML = `
                <div class="nores">
                    No notices available at the moment.
                </div>
            `;

            return;
        }


        list.innerHTML = "";


        notices.forEach(
            function (notice) {

                const item =
                    document.createElement(
                        "div"
                    );


                item.className =
                    "ni " +
                    (
                        notice.type ||
                        "info"
                    );


                item.innerHTML = `

                    <div class="nico">
                        ${escapeHtml(
                            notice.icon ||
                            "📢"
                        )}
                    </div>


                    <div>

                        <div class="ntag">
                            ${escapeHtml(
                                notice.type ||
                                "Notice"
                            )}
                        </div>


                        <div class="ntit">
                            ${escapeHtml(
                                notice.title ||
                                ""
                            )}
                        </div>


                        <div class="ndesc">
                            ${escapeHtml(
                                notice.content ||
                                ""
                            )}
                        </div>


                        ${
                            notice.notice_date
                                ? `
                                    <div class="rsrc">
                                        ${escapeHtml(
                                            notice.notice_date
                                        )}
                                    </div>
                                  `
                                : ""
                        }

                    </div>

                `;


                list.appendChild(
                    item
                );

            }
        );


    } catch (error) {

        console.error(
            "Notice loading error:",
            error
        );


        list.innerHTML = `
            <div class="nores">
                Could not load notices.
            </div>
        `;
    }
}


/* =========================================================
   ISLAMIC RESOURCES
========================================================= */

async function loadResources() {

    const ayah =
        document.getElementById(
            "gAyah"
        );

    const hadith =
        document.getElementById(
            "gHadith"
        );

    const articles =
        document.getElementById(
            "gArt"
        );


    if (
        !ayah &&
        !hadith &&
        !articles
    ) {
        return;
    }


    try {

        const response =
            await fetch(
                "api/resources.php"
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ||
                "Could not load resources."
            );
        }


        const resources =
            result.resources || [];


        if (ayah) {
            ayah.innerHTML = "";
        }

        if (hadith) {
            hadith.innerHTML = "";
        }

        if (articles) {
            articles.innerHTML = "";
        }


        resources.forEach(
            function (resource) {

                const card =
                    document.createElement(
                        "div"
                    );


                card.className =
                    "rc";


                card.innerHTML = `

                    ${
                        resource.title
                            ? `
                                <div class="rtitle">
                                    ${escapeHtml(
                                        resource.title
                                    )}
                                </div>
                              `
                            : ""
                    }


                    <div class="rtype">
                        ${escapeHtml(
                            resource.type ||
                            ""
                        )}
                    </div>


                    ${
                        resource.arabic
                            ? `
                                <div class="rarabic">
                                    ${escapeHtml(
                                        resource.arabic
                                    )}
                                </div>
                              `
                            : ""
                    }


                    <div class="rtrans">
                        ${escapeHtml(
                            resource.content ||
                            ""
                        )}
                    </div>


                    ${
                        resource.source
                            ? `
                                <div class="rsrc">
                                    ${escapeHtml(
                                        resource.source
                                    )}
                                </div>
                              `
                            : ""
                    }


                    ${
                        resource.author
                            ? `
                                <div class="rsrc">
                                    ${escapeHtml(
                                        resource.author
                                    )}
                                </div>
                              `
                            : ""
                    }

                `;


                if (
                    resource.type ===
                    "ayah" &&
                    ayah
                ) {

                    ayah.appendChild(
                        card
                    );

                }

                else if (
                    resource.type ===
                    "hadith" &&
                    hadith
                ) {

                    hadith.appendChild(
                        card
                    );

                }

                else if (
                    resource.type ===
                    "article" &&
                    articles
                ) {

                    articles.appendChild(
                        card
                    );
                }

            }
        );


        if (
            ayah &&
            !ayah.children.length
        ) {

            ayah.innerHTML =
                `<div class="nores">
                    No Ayah available.
                </div>`;
        }


        if (
            hadith &&
            !hadith.children.length
        ) {

            hadith.innerHTML =
                `<div class="nores">
                    No Hadith available.
                </div>`;
        }


        if (
            articles &&
            !articles.children.length
        ) {

            articles.innerHTML =
                `<div class="nores">
                    No articles available.
                </div>`;
        }


    } catch (error) {

        console.error(
            "Resource loading error:",
            error
        );


        const message =
            `<div class="nores">
                Could not load resources.
            </div>`;


        if (ayah) {
            ayah.innerHTML =
                message;
        }

        if (hadith) {
            hadith.innerHTML =
                message;
        }

        if (articles) {
            articles.innerHTML =
                message;
        }
    }
}


/* =========================================================
   DONATION TARGET
========================================================= */

let selectedDonationTarget = {

    campaign_id:
        null,

    cause_id:
        null
};


/* =========================================================
   OPEN DONATION MODAL
========================================================= */

function openDonate(
    title,
    campaignId = null,
    causeId = null
) {

    selectedDonationTarget = {

        campaign_id:
            campaignId,

        cause_id:
            causeId
    };


    const modal =
        document.getElementById(
            "donMov"
        );

    const form =
        document.getElementById(
            "donF"
        );

    const success =
        document.getElementById(
            "donSucc"
        );

    const titleElement =
        document.getElementById(
            "donTitle"
        );


    if (!modal) {

        console.error(
            "Donation modal #donMov was not found."
        );

        return;
    }


    if (form) {

        form.style.display =
            "block";
    }


    if (success) {

        success.style.display =
            "none";
    }


    if (titleElement) {

        titleElement.textContent =
            title ||
            "Donate via bKash";
    }


    modal.classList.add(
        "open"
    );


    document.body.style.overflow =
        "hidden";
}


/* =========================================================
   CLOSE DONATION MODAL
========================================================= */

function closeDonate() {

    const modal =
        document.getElementById(
            "donMov"
        );


    if (modal) {

        modal.classList.remove(
            "open"
        );
    }


    document.body.style.overflow =
        "";
}


/* =========================================================
   LOAD PUBLIC DONATION DATA
========================================================= */

async function loadDonationData() {

    const campGrid =
        document.getElementById(
            "campGrid"
        );

    const causeGrid =
        document.getElementById(
            "causeGrid"
        );

    const cdGrid =
        document.getElementById(
            "cdGrid"
        );


    const genRaised =
        document.getElementById(
            "genRaised"
        );

    const campRaisedTotal =
        document.getElementById(
            "campRaisedTotal"
        );


    if (
        !campGrid &&
        !causeGrid &&
        !cdGrid
    ) {

        return;
    }


    try {

        const response =
            await fetch(
                "api/public_donations.php"
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ||
                "Could not load donation information."
            );
        }


        /* TOTALS */

        if (genRaised) {

            genRaised.textContent =
                "৳" +
                Number(
                    result.general_raised ||
                    0
                ).toLocaleString();
        }


        if (campRaisedTotal) {

            campRaisedTotal.textContent =
                "৳" +
                Number(
                    result.campaign_raised ||
                    0
                ).toLocaleString();
        }


        /* =================================================
           CAMPAIGNS
        ================================================= */

        if (campGrid) {

            campGrid.innerHTML = "";


            const campaigns =
                result.campaigns ||
                [];


            if (
                campaigns.length === 0
            ) {

                campGrid.innerHTML = `
                    <div class="nores">
                        No event or activity fundraising
                        campaigns are available right now.
                    </div>
                `;

            }

            else {

                campaigns.forEach(
                    function (campaign) {

                        const card =
                            document.createElement(
                                "div"
                            );


                        card.className =
                            "ecard";


                        const target =
                            Number(
                                campaign.goal_amount ||
                                0
                            );


                        const raised =
                            Number(
                                campaign.raised_amount ||
                                0
                            );


                        const percentage =
                            target > 0
                                ? Math.min(
                                    100,
                                    Math.round(
                                        raised /
                                        target *
                                        100
                                    )
                                )
                                : 0;


                        card.innerHTML = `

                            <div class="ebar"></div>


                            <div class="ebody">

                                <div class="edate">
                                    🤝 Fundraising
                                </div>


                                <h3 class="etitle">
                                    ${escapeHtml(
                                        campaign.title ||
                                        ""
                                    )}
                                </h3>


                                <p class="edesc">
                                    ${escapeHtml(
                                        campaign.description ||
                                        ""
                                    )}
                                </p>


                                <div class="emeta">

                                    <span>
                                        💰 Raised:
                                        ৳${raised.toLocaleString()}
                                    </span>


                                    <span>
                                        🎯 Goal:
                                        ৳${target.toLocaleString()}
                                    </span>

                                </div>


                                <div style="
                                    height:8px;
                                    background:#eadcf3;
                                    border-radius:20px;
                                    overflow:hidden;
                                    margin:1rem 0;
                                ">

                                    <div style="
                                        width:${percentage}%;
                                        height:100%;
                                        background:linear-gradient(
                                            to right,
                                            var(--rose),
                                            var(--gold)
                                        );
                                    "></div>

                                </div>


                                <button
                                    class="btn-g bfull donate-campaign-btn"
                                    type="button"
                                >
                                    🤲 Donate via bKash
                                </button>

                            </div>
                        `;


                        const button =
                            card.querySelector(
                                ".donate-campaign-btn"
                            );


                        if (button) {

                            button.addEventListener(
                                "click",
                                function () {

                                    openDonate(
                                        campaign.title ||
                                        "Fundraising Donation",

                                        campaign.id,

                                        null
                                    );
                                }
                            );
                        }


                        campGrid.appendChild(
                            card
                        );

                    }
                );
            }
        }


        /* =================================================
           CAUSES
        ================================================= */

        if (causeGrid) {

            causeGrid.innerHTML = "";


            const causes =
                result.causes ||
                [];


            if (
                causes.length === 0
            ) {

                causeGrid.innerHTML = `

                    <div class="nores">
                        No specific causes are available.
                        You can still make a general donation below.
                    </div>


                    <div class="ecard">

                        <div class="ebar"></div>


                        <div class="ebody">

                            <div class="edate">
                                💗 General Donation
                            </div>


                            <h3 class="etitle">
                                Support SEC Muslimah
                            </h3>


                            <p class="edesc">
                                Support the general activities,
                                educational programs and community
                                work of SEC Muslimah.
                            </p>


                            <button
                                class="btn-g bfull general-donate-btn"
                                type="button"
                            >
                                🤲 Donate via bKash
                            </button>

                        </div>

                    </div>
                `;


                const generalButton =
                    causeGrid.querySelector(
                        ".general-donate-btn"
                    );


                if (generalButton) {

                    generalButton.addEventListener(
                        "click",
                        function () {

                            openDonate(
                                "General SEC Muslimah Donation"
                            );

                        }
                    );
                }

            }

            else {

                causes.forEach(
                    function (cause) {

                        const card =
                            document.createElement(
                                "div"
                            );


                        card.className =
                            "ecard";


                        const target =
                            Number(
                                cause.goal_amount ||
                                0
                            );


                        const raised =
                            Number(
                                cause.raised_amount ||
                                0
                            );


                        const percentage =
                            target > 0
                                ? Math.min(
                                    100,
                                    Math.round(
                                        raised /
                                        target *
                                        100
                                    )
                                )
                                : 0;


                        card.innerHTML = `

                            <div class="ebar"></div>


                            <div class="ebody">

                                <div class="edate">
                                    💗 Donation Cause
                                </div>


                                <h3 class="etitle">
                                    ${escapeHtml(
                                        cause.title ||
                                        ""
                                    )}
                                </h3>


                                <p class="edesc">
                                    ${escapeHtml(
                                        cause.description ||
                                        ""
                                    )}
                                </p>


                                <div class="emeta">

                                    <span>
                                        💰 Raised:
                                        ৳${raised.toLocaleString()}
                                    </span>


                                    <span>
                                        🎯 Goal:
                                        ৳${target.toLocaleString()}
                                    </span>

                                </div>


                                <div style="
                                    height:8px;
                                    background:#eadcf3;
                                    border-radius:20px;
                                    overflow:hidden;
                                    margin:1rem 0;
                                ">

                                    <div style="
                                        width:${percentage}%;
                                        height:100%;
                                        background:linear-gradient(
                                            to right,
                                            var(--rose),
                                            var(--gold)
                                        );
                                    "></div>

                                </div>


                                <button
                                    class="btn-g bfull donate-cause-btn"
                                    type="button"
                                >
                                    🤲 Donate via bKash
                                </button>

                            </div>
                        `;


                        const button =
                            card.querySelector(
                                ".donate-cause-btn"
                            );


                        if (button) {

                            button.addEventListener(
                                "click",
                                function () {

                                    openDonate(
                                        cause.title ||
                                        "Donation Cause",

                                        null,

                                        cause.id
                                    );

                                }
                            );
                        }


                        causeGrid.appendChild(
                            card
                        );

                    }
                );
            }
        }


        /* =================================================
           CLOTHES COLLECTION
        ================================================= */

        if (cdGrid) {

            cdGrid.innerHTML = "";


            const clothes =
                result.clothes ||
                [];


            if (
                clothes.length === 0
            ) {

                cdGrid.innerHTML = `
                    <div class="nores">
                        No clothes collection drive is active
                        right now.
                    </div>
                `;

            }

            else {

                clothes.forEach(
                    function (drive) {

                        const card =
                            document.createElement(
                                "div"
                            );


                        card.className =
                            "ecard";


                        card.innerHTML = `

                            <div class="ebar"></div>


                            <div class="ebody">

                                <div class="edate">
                                    🧥 Clothes Collection
                                </div>


                                <h3 class="etitle">
                                    ${escapeHtml(
                                        drive.title ||
                                        ""
                                    )}
                                </h3>


                                <p class="edesc">
                                    ${escapeHtml(
                                        drive.description ||
                                        ""
                                    )}
                                </p>


                                <div class="emeta">

                                    <span>
                                        📍 ${escapeHtml(
                                            drive.dropoff_location ||
                                            ""
                                        )}
                                    </span>


                                    ${
                                        drive.deadline
                                            ? `
                                                <span>
                                                    📅 ${escapeHtml(
                                                        drive.deadline
                                                    )}
                                                </span>
                                              `
                                            : ""
                                    }

                                </div>


                                <button
                                    class="btn-g bfull pledge-info-btn"
                                    type="button"
                                >
                                    🧥 Pledge Clothes
                                </button>

                            </div>
                        `;


                        /*
                         * IMPORTANT:
                         * Your current project has the
                         * "Pledge Clothes" button in the HTML/
                         * generated card, but there is no
                         * pledge API or pledge modal function
                         * in the attached app.js.
                         *
                         * Therefore we do NOT pretend the
                         * pledge was submitted.
                         */

                        const pledgeButton =
                            card.querySelector(
                                ".pledge-info-btn"
                            );


                        if (pledgeButton) {

                            pledgeButton.addEventListener(
                                "click",
                                function () {

                                    alert(
                                        "The clothes pledge form is not connected yet. The clothes drive information is available, but a pledge submission API/form has not been added to this project yet."
                                    );

                                }
                            );
                        }


                        cdGrid.appendChild(
                            card
                        );

                    }
                );
            }
        }


    } catch (error) {

        console.error(
            "Donation loading error:",
            error
        );


        if (campGrid) {

            campGrid.innerHTML =
                `<div class="nores">
                    Could not load fundraising data.
                </div>`;
        }


        if (causeGrid) {

            causeGrid.innerHTML =
                `<div class="nores">
                    Could not load donation data.
                </div>`;
        }


        if (cdGrid) {

            cdGrid.innerHTML =
                `<div class="nores">
                    Could not load clothes drives.
                </div>`;
        }
    }
}


/* =========================================================
   SUBMIT DONATION
========================================================= */

async function submitDonation() {

    const nameElement =
        document.getElementById(
            "dName"
        );

    const phoneElement =
        document.getElementById(
            "dPhone"
        );

    const senderElement =
        document.getElementById(
            "dSender"
        );

    const trxElement =
        document.getElementById(
            "dTrx"
        );

    const amountElement =
        document.getElementById(
            "dAmt"
        );

    const noteElement =
        document.getElementById(
            "dNote"
        );


    if (
        !nameElement ||
        !phoneElement ||
        !senderElement ||
        !trxElement ||
        !amountElement
    ) {

        return;
    }


    const name =
        nameElement.value.trim();

    const phone =
        phoneElement.value.trim();

    const sender =
        senderElement.value.trim();

    const trx =
        trxElement.value.trim();

    const amount =
        amountElement.value.trim();

    const note =
        noteElement
            ? noteElement.value.trim()
            : "";


    if (
        !name ||
        !phone ||
        !sender ||
        !trx ||
        !amount ||
        Number(amount) <= 0
    ) {

        alert(
            "Please fill in Name, Phone, bKash Number, Transaction ID and a valid Amount."
        );

        return;
    }


    const button =
        document.querySelector(
            "#donF .btn-g"
        );


    if (button) {

        button.disabled =
            true;

        button.textContent =
            "Submitting...";
    }


    try {

        const response =
            await fetch(
                "api/donations.php",
                {
                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/json"
                    },

                    body: JSON.stringify({

                        name:
                            name,

                        phone:
                            phone,

                        bkash_number:
                            sender,

                        trx_id:
                            trx,

                        amount:
                            Number(amount),

                        campaign_id:
                            selectedDonationTarget
                                .campaign_id,

                        cause_id:
                            selectedDonationTarget
                                .cause_id,

                        note:
                            note
                    })
                }
            );


        const result =
            await response.json();


        if (
            !response.ok ||
            !result.success
        ) {

            throw new Error(
                result.message ||
                "Could not submit donation."
            );
        }


        const form =
            document.getElementById(
                "donF"
            );

        const success =
            document.getElementById(
                "donSucc"
            );


        if (form) {

            form.style.display =
                "none";
        }


        if (success) {

            success.style.display =
                "block";
        }


    } catch (error) {

        console.error(
            "Donation submission error:",
            error
        );


        alert(
            error.message ||
            "Something went wrong. Please try again."
        );


        if (button) {

            button.disabled =
                false;

            button.textContent =
                "✦ Submit Donation Details";
        }
    }
}


/* =========================================================
   HTML ESCAPING
========================================================= */

function escapeHtml(value) {

    return String(
        value ?? ""
    )
        .replace(
            /&/g,
            "&amp;"
        )
        .replace(
            /</g,
            "&lt;"
        )
        .replace(
            />/g,
            "&gt;"
        )
        .replace(
            /"/g,
            "&quot;"
        )
        .replace(
            /'/g,
            "&#039;"
        );
}


/* =========================================================
   START ALL PUBLIC CONTENT
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        loadEvents();

        loadNotices();

        loadResources();

        loadDonationData();

    }
);