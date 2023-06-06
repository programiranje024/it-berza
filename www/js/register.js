function setRole(role) {
  const companyName = document.getElementsByName("company_name")[0];
  const companyAddress = document.getElementsByName("company_address")[0];
  const companyWebsite = document.getElementsByName("company_website")[0];

  companyName.setAttribute("required", role === "company");
  companyAddress.setAttribute("required", role === "company");
  companyWebsite.setAttribute("required", role === "company");

  companyName.setAttribute("type", role === "company" ? "text" : "hidden");
  companyAddress.setAttribute("type", role === "company" ? "text" : "hidden");
  companyWebsite.setAttribute("type", role === "company" ? "text" : "hidden");
}

setRole("user");
