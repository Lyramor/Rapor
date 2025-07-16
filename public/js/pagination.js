// Script untuk pagination
function updatePagination(response) {
    const paginationContainer = document.querySelector("#pagination-container");
    paginationContainer.innerHTML = "";

    const totalPages = response.last_page;
    const currentPage = response.current_page;
    const totalData = response.total; // Menambah total data dari respons
    const perPage = response.per_page; // Jumlah data per halaman dari respons

    let paginationHTML = `<div class="row justify-content-center">
                            <div class="col-md-11">
                                Total data: <span id="total-data">${totalData}</span>
                            </div>
                            <div class="col-md-1">
                            <select id="perPage" class="form-select" onchange="changePerPage(this.value)">
                            ${[10, 20, 50, 100]
                                .map(
                                    (size) => `
                                                <option value="${
                                                    response.url
                                                }?perPage=${size}" ${
                                        perPage === size ? "selected" : ""
                                    }>
                                        ${size}
                                    </option>
                                            `
                                )
                                .join("")}
                        </select>
                            </div>
                        </div>`;

    if (totalPages > 1) {
        paginationHTML += `
                        <ul class="pagination justify-content-md-end mt-3">
                            <li class="page-item ${
                                currentPage === 1 ? "disabled" : ""
                            }">
                                <a class="page-link" href="#" onclick="searchData(${
                                    currentPage - 1
                                }, ${perPage})">Previous</a>
                            </li>`;

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
                            <li class="page-item ${
                                currentPage === i ? "active" : ""
                            }">
                                <a class="page-link" href="#" onclick="searchData(${i}, ${perPage})">${i}</a>
                            </li>`;
        }

        paginationHTML += `
                        <li class="page-item ${
                            currentPage === totalPages ? "disabled" : ""
                        }">
                            <a class="page-link" href="#" onclick="searchData(${
                                currentPage + 1
                            }, ${perPage})">Next</a>
                        </li>
                    </ul>`;
    }
    paginationContainer.innerHTML = paginationHTML;

    // Menampilkan total data
    const totalDataElement = document.querySelector("#total-data");
    totalDataElement.textContent = totalData;
}

function changePerPage(newPerPage) {
    searchData(1, newPerPage); // Memanggil ulang data dengan halaman 1 dan perPage baru
}
