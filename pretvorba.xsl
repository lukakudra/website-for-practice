<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="- //W3C//DTD XHTML 1.0 Strict//EN" />
    <xsl:template match="/">
        <html
            xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8"/>
                <title>Podaci</title>
                <link rel="stylesheet" type="text/css" href="dizajn.css"/>
            </head>
            <body>
                <div class="container">
                    <header>
                        <div class="slon">
                            <img src="elephant.png" alt="picture-of-elephant"/>
                        </div>
                        <h1>Zoološki vrtovi u svijetu</h1>
                        <div class="slon-flipped">
                            <img src="elephant-flipped.png" alt="picture-of-elephant-flipped"/>
                        </div>
                    </header>

                    <div class="navigacija-index">
                        <nav>
                            <ul>
                                <li>
                                    <a href="index.html">Početna stranica</a>
                                </li>
                                <li>
                                    <a href="obrazac.html">Pretraživanje</a>
                                </li>
                                <li class="podaci-xml">
                                    <a href="podaci.xml">Podaci</a>
                                </li>
                                <li>
                                    <a href="http://www.fer.unizg.hr/predmet/or">Otvoreno računarstvo</a>
                                </li>
                                <li>
                                    <a target="_blank" href="http://www.fer.unizg.hr/">FER</a>
                                </li>
                                <li>
                                    <a href="mailto:luka.kudra@gmail.com">Mail kontakt</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <article>
                        <h2>Podaci</h2>

                        <div class="podaci">
                            <table>
                                <tr>
                                    <th>Ime</th>
                                    <th>Kontinent</th>
                                    <th>Država</th>
                                    <th>Mjesto</th>
                                    <th>Ulica i kućni broj</th>
                                    <th>Cijena ulaznice [$]</th>
                                    <th>Parking mjesto</th>
                                    <th>Dozvoljeno hranjenje životinja</th>
                                    <th>Broj vrsta</th>
                                    <th>Broj posjetitelja</th>
                                    <th>Mail adresa</th>
                                </tr>

                                <xsl:for-each select="/zooloski-vrtovi/zooloski-vrt">
                                    <tr>
                                        <td>
                                            <xsl:value-of select="ime" />
                                        </td>
                                        <td>
                                            <xsl:value-of select="@kontinent" />
                                        </td>
                                        <td>
                                            <xsl:value-of select="adresa/drzava" />
                                        </td>
                                        <td>
                                            <xsl:value-of select="adresa/mjesto" />
                                        </td>
                                        <td>
                                            <xsl:value-of select="adresa/ulica" />,
                                            <xsl:value-of select = "adresa/ulica/@kucni-broj" />
                                        </td>
                                        <td>
                                            <xsl:value-of select="cijena-ulaznice" />
                                        </td>
                                        <td>
                                            <xsl:choose>
                                                <xsl:when test="parking-mjesto">
                                                    <xsl:value-of select="parking-mjesto" />
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    Nije poznato
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td>
                                            <xsl:choose>
                                                <xsl:when test="dozvoljeno-hranjenje">
                                                    <xsl:value-of select="dozvoljeno-hranjenje" />
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    Nije poznato
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td>
                                            <xsl:choose>
                                                <xsl:when test="broj-vrsta &gt; 275">
                                                    <xsl:value-of select="broj-vrsta" />
                                                </xsl:when>
                                                <xsl:when test="broj-vrsta">
                                                    Manje od 275 vrsta
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    Podatak nije poznat
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td>
                                            <xsl:choose>
                                            
                                                <xsl:when test="broj-posjetitelja">
                                                    <xsl:value-of select="broj-posjetitelja" />
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    -
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                        <td>
                                            <xsl:choose>
                                                <xsl:when test="mail-adresa">
                                                    <xsl:for-each select="mail-adresa[position() != last()]">
                                                        <xsl:value-of select="string()" />,
                                                        <br/>
                                                    </xsl:for-each>
                                                    <xsl:for-each select="mail-adresa[last()]">
                                                        <xsl:value-of select="string()" />
                                                        <br/>
                                                    </xsl:for-each>
                                                </xsl:when>
                                                <xsl:otherwise>
                                                    -
                                                </xsl:otherwise>
                                            </xsl:choose>
                                        </td>
                                    </tr>
                                </xsl:for-each>
                            </table>
                        </div>
                    </article>

                    <footer>
                        <p>Autor: Luka Kudra</p>
                        <p>Fakultet elektrotehnike i računarstva, Zagreb</p>
                    </footer>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>