export function clearResultError()
{
    let divresults = document.querySelectorAll(".results");
    if(divresults)
    {
        divresults.forEach(result=>
            {
                result.style.display= "none";
        })
    }
}
export function showSpinners()
{
    let spinnerwaper = document.querySelector(".spinnerwaper");
    spinnerwaper.classList.add("show")
}
export function hideSpinners()
{
    let spinnerwaper = document.querySelector(".spinnerwaper");
    spinnerwaper.classList.remove("show")
}