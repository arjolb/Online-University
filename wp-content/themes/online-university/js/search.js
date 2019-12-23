jQuery(document).ready(function ($) {
    //Variables
    var openBtn = $('.search');
    var closeBtn = $('.fa-window-close');
    var searchOverlay = $('.search-overlay');
    var searchField = $("#search-term");
    var resultsDiv = $(".search-overlay--results");
    var isOverlayOpen = false;
    var isSpinnerVisible = false;
    var previousValue;
    var typingTimer;

    
    //Events
    openBtn.on('click',openOverlay);
    closeBtn.on('click',closeOverlay);
    $(document).on('keydown',keyPressFn);
    searchField.on('keyup',typingLogic);


    //Functions
    function openOverlay(e) {
        searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        setTimeout(function () {
            searchField.focus();
        }, 201);
        searchField.val('');
        isOverlayOpen = true;

        return false;
    }

    function closeOverlay(e) {
        searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        isOverlayOpen = false;
        searchField.blur();
        resultsDiv.html('');
    }

    function keyPressFn(e) {
        if (e.keyCode == 83 && !isOverlayOpen && !$("input, textarea").is(':focus')) {
            openOverlay();
        }
    
        if (e.keyCode == 27 && isOverlayOpen) {
            closeOverlay();
        }
    }


    
    function getResults(){
        $.getJSON(
            data.root_url + '/wp-json/searchroute/v1/search?keyword='+searchField.val(),
            function (results) {
                resultsDiv.html(`
                    <div class="search-overlay--results__content row">
                        <div class="col col-xs-3">
                            <h2>Blog posts and pages</h2>
                            ${results.postsPages.length ? '' : '<p>No posts and pages match your search.</p>'}
                              ${results.postsPages.map(item => `
                                <div class="blog-posts-subjects">
                                    <a href="${item.permalink}">${item.title}</a>
                                </div>
                                `).join('')}
                        </div>
                        <div class="col col-xs-3">
                            <h2>Lectures</h2>
                            ${results.lectures.length ? '' : '<p>No lecture match your search.</p>'}
                              ${results.lectures.map(item => `
                              <div class="lecture">
                                    <div class="lecture-date">
                                        <div><h3>${item.month}</h3>
                                        <h3>${item.day}</h3></div>
                                    </div>
                                    <div class="lecture-content">
                                        <a href="${item.permalink}">${item.title}</a>
                                        <p>${item.content}</p>
                                    </div>
                              </div>`).join('')}
                        </div>
                        <div class="col col-xs-3">
                            <h2>Subjects</h2>
                            ${results.subjects.length ? '' : '<p>No subjects match your search.</p>'}
                              ${results.subjects.map(item => `
                                <div class="blog-posts-subjects">
                                    <a href="${item.permalink}">${item.title}</a>
                                </div>
                                `).join('')}
                        </div>
                        <div class="col col-xs-3">
                            <h2>Professors</h2>
                            ${results.professors.length ? '' : '<p>No professors match your search.</p>'}
                              ${results.professors.map(item => `
                                <a class="professor" href="${item.permalink}">
                                    <img src="${item.image}" alt="professor-thumbnail">
                                    <div class="professor-title">
                                        <h4>${item.title}</h4>
                                    </div>
                                </a>
                              `).join('')}
                        </div>
                    </div>
                `);
            }
        );
        isSpinnerVisible = false;
    }
    
    function typingLogic(e) {
        if (searchField.val() != previousValue) {
            clearTimeout(typingTimer);

            if (searchField.val()) {
                if (!isSpinnerVisible) {
                    resultsDiv.html('<div class="spinner-loader"></div>');
                    isSpinnerVisible = true;
                }    
                typingTimer = setTimeout(getResults, 850);
            } else {
                resultsDiv.html('');
                isSpinnerVisible = false;
            }
        }

        previousValue = searchField.val();
    }
})